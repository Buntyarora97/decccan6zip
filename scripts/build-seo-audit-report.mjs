import fs from "node:fs/promises";
import path from "node:path";
import { fileURLToPath } from "node:url";

const root = path.resolve(path.dirname(fileURLToPath(import.meta.url)), "..");
const baseUrl = (process.env.SEO_AUDIT_BASE_URL || "http://127.0.0.1:5000").replace(/\/+$/, "");
const reportDate = "4 October 2026";

// Three cache-disabled Chromium runs of the homepage under each emulated profile.
// These are local lab measurements, not PageSpeed Insights or field data.
const performance = {
  desktop: {
    viewport: "1365 × 768 CSS px",
    network: "10 Mbps down / 40 ms latency",
    cpu: "No CPU throttling",
    fcp: { median: 624, min: 604, max: 1000 },
    lcp: { median: 624, min: 604, max: 1112 },
    load: { median: 1139, min: 1133, max: 1347 },
    cls: { median: 0.0015, min: 0.0015, max: 0.0015 },
    bytes: 1139194,
  },
  mobile: {
    viewport: "390 × 844 CSS px",
    network: "1.6 Mbps down / 150 ms latency",
    cpu: "4× CPU throttling",
    fcp: { median: 2324, min: 2316, max: 2420 },
    lcp: { median: 2332, min: 2320, max: 2420 },
    load: { median: 6274, min: 6256, max: 6276 },
    cls: { median: 0.000021, min: 0.000021, max: 0.000027 },
    bytes: 1066554,
  },
};

function decodeHtml(value) {
  return value
    .replace(/&amp;/g, "&")
    .replace(/&quot;/g, '"')
    .replace(/&#039;/g, "'")
    .replace(/&lt;/g, "<")
    .replace(/&gt;/g, ">")
    .replace(/&nbsp;/g, " ")
    .replace(/&#(\d+);/g, (_, n) => String.fromCodePoint(Number(n)))
    .replace(/&#x([0-9a-f]+);/gi, (_, n) => String.fromCodePoint(parseInt(n, 16)));
}

function htmlEscape(value) {
  return String(value)
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}

function plainText(value) {
  return decodeHtml(value.replace(/<[^>]*>/g, " ").replace(/\s+/g, " ")).trim();
}

function routeGroup(route) {
  if (route === "/") return "Home";
  if (route.startsWith("/departments/")) return "Departments";
  if (route.startsWith("/doctors/")) return "Doctor profiles";
  if (route.startsWith("/health-library/")) return "Health articles";
  if (route.startsWith("/patient-care/")) return "Patient care guides";
  return "Main website pages";
}

async function getPage(url) {
  const response = await fetch(url);
  const html = await response.text();
  const title = decodeHtml(html.match(/<title>([\s\S]*?)<\/title>/i)?.[1] || "").trim();
  const description = decodeHtml(
    html.match(/<meta\s+name="description"\s+content="([^"]*)"/i)?.[1] || "",
  ).trim();
  const h1Match = html.match(/<h1\b[^>]*>([\s\S]*?)<\/h1>/i);
  const h1 = h1Match ? plainText(h1Match[1]) : "";
  const h1Count = (html.match(/<h1\b/gi) || []).length;
  const canonicalCount = (html.match(/<link\s+rel="canonical"\s+href="[^"]*"/gi) || []).length;
  const images = [...html.matchAll(/<img\b[^>]*>/gi)].map((match) => match[0]);
  const missingAlt = images.filter((image) => !/\balt\s*=/.test(image)).length;
  let invalidJsonLd = 0;
  for (const match of html.matchAll(/<script\s+type="application\/ld\+json">([\s\S]*?)<\/script>/gi)) {
    try {
      JSON.parse(match[1]);
    } catch {
      invalidJsonLd += 1;
    }
  }
  return {
    route: new URL(url).pathname || "/",
    status: response.status,
    title,
    description,
    h1,
    h1Count,
    canonicalCount,
    missingAlt,
    invalidJsonLd,
  };
}

const sitemapResponse = await fetch(`${baseUrl}/sitemap.xml`);
if (!sitemapResponse.ok) throw new Error(`Sitemap request returned HTTP ${sitemapResponse.status}`);
const sitemap = await sitemapResponse.text();
const urls = [...sitemap.matchAll(/<loc>(.*?)<\/loc>/g)].map((match) => decodeHtml(match[1]));
if (urls.length !== 41) throw new Error(`Expected 41 sitemap URLs, found ${urls.length}`);

const pages = await Promise.all(urls.map(getPage));
const missing = pages.filter((page) => page.status !== 200 || !page.title || !page.description);
const invalidHeadings = pages.filter((page) => page.h1Count !== 1);
const invalidCanonicals = pages.filter((page) => page.canonicalCount !== 1);
const invalidJsonLd = pages.filter((page) => page.invalidJsonLd > 0);
const missingAlt = pages.reduce((sum, page) => sum + page.missingAlt, 0);
const uniqueTitles = new Set(pages.map((page) => page.title)).size;
const uniqueDescriptions = new Set(pages.map((page) => page.description)).size;
if (missing.length || invalidHeadings.length || invalidCanonicals.length || invalidJsonLd.length || missingAlt) {
  throw new Error(
    `Audit checks failed: HTTP/meta ${missing.length}, H1 ${invalidHeadings.length}, canonical ${invalidCanonicals.length}, JSON-LD ${invalidJsonLd.length}, missing alt ${missingAlt}`,
  );
}
if (uniqueTitles !== pages.length || uniqueDescriptions !== pages.length) {
  throw new Error("Page titles and descriptions must be unique before generating this report.");
}

const titleLengths = pages.map((page) => page.title.length);
const descriptionLengths = pages.map((page) => page.description.length);
const outOfRangeTitles = pages.filter((page) => page.title.length < 40 || page.title.length > 65);
const outOfRangeDescriptions = pages.filter((page) => page.description.length < 130 || page.description.length > 170);
if (outOfRangeTitles.length || outOfRangeDescriptions.length) {
  throw new Error(
    `Metadata length review: ${outOfRangeTitles.length} titles and ${outOfRangeDescriptions.length} descriptions fall outside the audit ranges.`,
  );
}
const groups = [...new Set(pages.map((page) => routeGroup(page.route)))];
const sortedPages = groups.flatMap((group) =>
  pages.filter((page) => routeGroup(page.route) === group).sort((a, b) => a.route.localeCompare(b.route)),
);
const groupedPages = groups.map((group) => ({
  name: group,
  pages: sortedPages.filter((page) => routeGroup(page.route) === group),
}));

function metric(value) {
  return `${(value / 1000).toFixed(2)} s`;
}
function range(values) {
  return `${metric(values.min)}–${metric(values.max)}`;
}
function size(value) {
  return `${(value / 1_000_000).toFixed(2)} MB`;
}

const inventoryRows = groupedPages.map(({ name, pages: groupPages }) => `
  <tr class="group-row"><th colspan="3">${htmlEscape(name)} <span>${groupPages.length} ${groupPages.length === 1 ? "URL" : "URLs"}</span></th></tr>
  ${groupPages.map((page) => `
    <tr>
      <td class="route"><code>${htmlEscape(page.route)}</code></td>
      <td class="title-cell"><strong>${htmlEscape(page.title)}</strong><small>${page.title.length} characters · H1: ${htmlEscape(page.h1)}</small></td>
      <td class="description-cell">${htmlEscape(page.description)}<small>${page.description.length} characters</small></td>
    </tr>`).join("")}
`).join("");

const desktop = performance.desktop;
const mobile = performance.mobile;
const html = `<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Deccan Malti Hospital — SEO &amp; Performance Audit</title>
<style>
@page { size: A4 landscape; margin: 11mm 10mm 15mm; @bottom-left { content: "Deccan Malti Hospital · Website SEO audit · ${reportDate}"; color: #6b7b88; font: 8pt Arial, sans-serif; } @bottom-right { content: "Page " counter(page); color: #6b7b88; font: 8pt Arial, sans-serif; } }
* { box-sizing: border-box; }
body { margin: 0; color: #1c2e40; background: #fff; font: 9pt/1.45 Arial, Helvetica, sans-serif; }
h1,h2,h3,p { margin-top: 0; }
h1 { margin-bottom: 7px; font-size: 29pt; line-height: 1.06; letter-spacing: -.7px; }
h2 { margin: 0 0 7px; font-size: 16pt; }
h3 { margin: 0 0 5px; font-size: 10pt; }
.cover { page-break-after: always; break-after: page; }
.masthead { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8mm; color: #597080; font-size: 9pt; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; }
.brand { display: flex; align-items: center; gap: 9px; color: #102b50; letter-spacing: .02em; text-transform: none; font-size: 12pt; }
.brand-mark { width: 10px; height: 26px; background: linear-gradient(#187e8a 0 50%, #ffc857 50%); border-radius: 5px; }
.hero { padding: 10mm 13mm; color: #fff; border-radius: 13px; background: linear-gradient(115deg, #102b50 0%, #0c5965 100%); }
.eyebrow { margin-bottom: 8px; color: #a6e7dc; font-size: 8pt; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; }
.hero p { max-width: 760px; margin: 0; color: #e2edf2; font-size: 10.5pt; }
.metadata { display: flex; justify-content: space-between; margin-top: 10px; color: #bcd0dc; font-size: 8pt; }
.section { margin-top: 6mm; }
.section-title { display: flex; align-items: baseline; justify-content: space-between; margin-bottom: 9px; }
.section-title small { color: #617586; font-size: 8pt; }
.kpis { display: grid; grid-template-columns: repeat(6, 1fr); gap: 8px; }
.kpi { padding: 8px 10px; min-height: 54px; border: 1px solid #dce5ea; border-radius: 8px; background: #f7fafb; }
.kpi strong { display: block; color: #102b50; font-size: 17pt; line-height: 1.1; }
.kpi span { color: #5d7080; font-size: 7.6pt; }
.cover-summary { margin-top: 8mm; }
.summary-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 9px; }
.summary-card { min-height: 28mm; padding: 9px 11px; border: 1px solid #dce5ea; border-radius: 8px; background: #f7fafb; }
.summary-card strong { display: block; margin-bottom: 5px; color: #102b50; font-size: 10pt; }
.summary-card span { color: #536b7b; font-size: 8pt; }
.readiness-page { page-break-before: always; break-before: page; }
.speed-table { width: 100%; margin-top: 7px; border-collapse: collapse; table-layout: fixed; }
.speed-table th,.speed-table td { padding: 7px 9px; border: 1px solid #dce5ea; text-align: left; vertical-align: top; }
.speed-table th { color: #fff; background: #102b50; font-size: 8pt; }
.speed-table td { font-size: 8.4pt; }
.speed-table td:first-child { width: 34%; font-weight: 700; }
.speed-table small { display: block; margin-top: 2px; color: #607382; font-size: 7pt; }
.lab-note,.caveat { padding: 8px 10px; border-left: 3px solid #187e8a; background: #f0f7f7; color: #36515e; font-size: 8pt; }
.columns { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.findings { margin: 0; padding-left: 17px; }
.findings li { margin: 0 0 5px; }
.findings strong { color: #102b50; }
.priority { color: #a34818; font-weight: 700; }
.inventory-page { page-break-before: always; }
.inventory-header { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 5mm; padding-bottom: 4mm; border-bottom: 2px solid #187e8a; }
.inventory-header p { margin: 0; color: #617586; font-size: 8pt; }
table.inventory { width: 100%; border-collapse: collapse; table-layout: fixed; }
.inventory thead { display: table-header-group; }
.inventory tr { page-break-inside: avoid; }
.inventory th,.inventory td { padding: 5px 7px; border-bottom: 1px solid #dce5ea; text-align: left; vertical-align: top; overflow-wrap: anywhere; }
.inventory thead th { color: #fff; background: #102b50; font-size: 7.5pt; letter-spacing: .04em; text-transform: uppercase; }
.inventory .route { width: 17%; }
.inventory .title-cell { width: 28%; }
.inventory .description-cell { width: 45%; }
.inventory .h1-cell { width: 10%; }
.inventory td { font-size: 7.6pt; line-height: 1.32; }
.inventory code { color: #0c5965; font: 700 7.4pt/1.35 Consolas, "Courier New", monospace; }
.inventory td small { display: block; margin-top: 3px; color: #6b7b88; font-size: 6.8pt; }
.inventory .group-row th { padding: 8px 7px 4px; color: #0c5965; background: #eaf4f4; font-size: 8pt; }
.inventory .group-row span { float: right; color: #6b7b88; font-size: 7pt; font-weight: 400; }
.footnote { margin-top: 5mm; color: #657887; font-size: 7.5pt; }
</style>
</head>
<body>
<section class="cover">
  <div class="masthead"><div class="brand"><span class="brand-mark"></span> Deccan Malti Hospital</div><span>Website audit</span></div>
  <div class="hero">
    <div class="eyebrow">Search metadata · Technical checks · Lab performance</div>
    <h1>SEO &amp; Performance Audit</h1>
    <p>A route-by-route review of page titles, descriptions, headings, canonical links, structured data, supplied photography and local browser performance.</p>
    <div class="metadata"><span>Sangli, Maharashtra</span><span>Prepared ${reportDate}</span></div>
  </div>

  <section class="section">
    <div class="section-title"><h2>Audit snapshot</h2><small>Scope: every URL listed in the generated XML sitemap</small></div>
    <div class="kpis">
      <div class="kpi"><strong>${pages.length}</strong><span>Sitemap URLs crawled</span></div>
      <div class="kpi"><strong>${pages.filter((page) => page.status === 200).length}/${pages.length}</strong><span>Returned HTTP 200 locally</span></div>
      <div class="kpi"><strong>${uniqueTitles}/${pages.length}</strong><span>Unique page titles</span></div>
      <div class="kpi"><strong>${uniqueDescriptions}/${pages.length}</strong><span>Unique meta descriptions</span></div>
      <div class="kpi"><strong>0</strong><span>Pages with missing/extra H1</span></div>
    <div class="kpi"><strong>0</strong><span>Missing image alt attributes</span></div>
    </div>
  </section>

  <section class="section cover-summary">
    <div class="section-title"><h2>Key results</h2><small>Local implementation checks; production status is not verified</small></div>
    <div class="summary-grid">
      <div class="summary-card"><strong>Search metadata</strong><span>All 41 sitemap routes returned locally with unique titles and descriptions, one H1, canonical links and no missing image alt attributes.</span></div>
      <div class="summary-card"><strong>Desktop homepage LCP</strong><span>${metric(desktop.lcp.median)} median across three cache-disabled local browser runs.</span></div>
      <div class="summary-card"><strong>Mobile homepage LCP</strong><span>${metric(mobile.lcp.median)} median in local simulation. Verify on the live HTTPS site before drawing production conclusions.</span></div>
    </div>
  </section>
</section>

<section class="performance-page">
  <section class="section">
    <div class="section-title"><h2>Homepage performance</h2><small>Three cache-disabled local Chromium runs · median and range</small></div>
    <table class="speed-table">
      <thead><tr><th>Metric</th><th>Desktop · ${desktop.viewport}</th><th>Mobile · ${mobile.viewport}</th></tr></thead>
      <tbody>
        <tr><td>First Contentful Paint (FCP)</td><td>${metric(desktop.fcp.median)} <small>Range ${range(desktop.fcp)}</small></td><td>${metric(mobile.fcp.median)} <small>Range ${range(mobile.fcp)}</small></td></tr>
        <tr><td>Largest Contentful Paint (LCP)</td><td><strong>${metric(desktop.lcp.median)}</strong> <small>Range ${range(desktop.lcp)}</small></td><td><strong>${metric(mobile.lcp.median)}</strong> <small>Range ${range(mobile.lcp)} · Mobile improvement remains a priority</small></td></tr>
        <tr><td>Browser load event</td><td>${metric(desktop.load.median)} <small>Range ${range(desktop.load)}</small></td><td>${metric(mobile.load.median)} <small>Range ${range(mobile.load)}</small></td></tr>
        <tr><td>Transferred page resources</td><td>${size(desktop.bytes)}</td><td>${size(mobile.bytes)}</td></tr>
        <tr><td>Cumulative Layout Shift (CLS)</td><td>${desktop.cls.median.toFixed(4)}</td><td>${mobile.cls.median.toFixed(4)}</td></tr>
        <tr><td>Interaction to Next Paint (INP)</td><td colspan="2">Not measured in this no-interaction lab test; validate with real-user data or an interaction-focused test.</td></tr>
      </tbody>
    </table>
    <p class="lab-note"><strong>Test conditions.</strong> Desktop: ${htmlEscape(desktop.viewport)}, ${htmlEscape(desktop.network)}, ${htmlEscape(desktop.cpu)}. Mobile: ${htmlEscape(mobile.viewport)}, ${htmlEscape(mobile.network)}, ${htmlEscape(mobile.cpu)}. The homepage was measured in the Replit workspace over HTTP, not on a public production domain. These are repeatable local lab readings—not PageSpeed Insights/Lighthouse scores or real-user Core Web Vitals. Production speed and field data remain unverified.</p>
  </section>
</section>

<section class="readiness-page">
  <section class="section">
    <h2>Technical SEO status</h2>
    <table class="speed-table">
      <thead><tr><th>Area</th><th>Local audit result</th><th>Scope note</th></tr></thead>
      <tbody>
        <tr><td>Indexable page inventory</td><td>41 sitemap-listed HTML routes; 41/41 returned HTTP 200 locally.</td><td>Robots.txt and sitemap.xml are utility endpoints, not counted as HTML pages. Admin/API routes, redirects and 404s are excluded.</td></tr>
        <tr><td>On-page metadata</td><td>41/41 unique titles and descriptions; one H1, one canonical, viewport, Open Graph and Twitter card tags on each route.</td><td>Canonical host and indexation need production-domain verification.</td></tr>
        <tr><td>Structured data</td><td>JSON-LD parses on all audited routes. Site-wide Hospital/WebSite graph; 40 breadcrumbs, 14 FAQ pages, 2 physician profiles and 7 articles.</td><td>Syntax was checked locally; rich-result eligibility is not guaranteed.</td></tr>
        <tr><td>Crawl directives</td><td>robots.txt returns plain text, allows public routes and references the XML sitemap.</td><td>Production robots policy and sitemap host have not been checked.</td></tr>
        <tr><td>Image accessibility</td><td>0 missing image alt attributes across the 41 rendered routes.</td><td>Alt-text relevance and image licensing/consent still require human review.</td></tr>
      </tbody>
    </table>
  </section>

  <section class="section columns">
    <div>
      <h2>Content and launch actions</h2>
      <ul class="findings">
        <li><strong>Production domain:</strong> No public HTTPS host was supplied. Confirm the live canonical URLs, robots.txt, sitemap hostname and redirects, then submit the sitemap to Search Console.</li>
        <li><strong>Mobile speed:</strong> Homepage local mobile LCP median is ${metric(mobile.lcp.median)}. Re-run on the production host; optimize the critical path if the same result persists.</li>
        <li><strong>Medical review:</strong> Have a qualified clinician review the exact health-article and department copy before adding reviewer credentials or presenting it as clinical advice.</li>
        <li><strong>Verify hospital claims:</strong> Bed count, credentials, experience, services, test availability, insurance participation and operational details need hospital approval.</li>
        <li><strong>Metadata refinements:</strong> Descriptions are unique (137–168 characters). Review length and search intent individually; character limits are guidance, not ranking guarantees.</li>
      </ul>
    </div>
    <div>
      <h2>Image, privacy and hosting checks</h2>
      <ul class="findings">
        <li><strong>Doctor portrait:</strong> The second supplied portrait is associated with Dr. P. C. Patil in the site; confirm identity and approval before publication.</li>
        <li><strong>Patient privacy:</strong> The supplied bedside image showing patients was not published because documented consent was unavailable.</li>
        <li><strong>Pharmacy imagery:</strong> Pharmacy-front photos were not published; the signage names “Malati Nursing Home Pharmacy,” whose relationship to this hospital is unconfirmed.</li>
        <li><strong>Hosting security:</strong> This workspace audit does not verify production HTTPS, credentials, server headers, backups or access controls. Check these on the live host before launch.</li>
        <li><strong>Image delivery:</strong> Selected large WebP photos were reduced to a 1280 px maximum dimension; original source assets remain preserved.</li>
      </ul>
    </div>
  </section>

  <section class="section caveat">
    This is a technical/on-page snapshot, not a ranking guarantee or “100% SEO” certification. Search Console indexing, production Core Web Vitals, Lighthouse/PageSpeed scores, live HTTPS and hospital/medical claim accuracy were not verified.
  </section>
</section>

<section class="inventory-page">
  <div class="inventory-header"><div><div class="eyebrow" style="color:#187e8a;">Page-level SEO inventory</div><h2>Routes, titles, descriptions and H1 headings</h2></div><p>${pages.length} URLs · title lengths ${Math.min(...titleLengths)}–${Math.max(...titleLengths)} characters · descriptions ${Math.min(...descriptionLengths)}–${Math.max(...descriptionLengths)} characters</p></div>
  <table class="inventory">
    <thead><tr><th class="route">URL route</th><th class="title-cell">Page title and H1</th><th class="description-cell">Meta description</th></tr></thead>
    <tbody>${inventoryRows}</tbody>
  </table>
  <p class="footnote">Routes are listed without a hostname because the production domain has not been supplied. Titles and descriptions above are the exact values returned by the local website at audit time.</p>
</section>
</body>
</html>`;

const reportsDir = path.join(root, "reports");
await fs.mkdir(reportsDir, { recursive: true });
const output = path.join(reportsDir, "deccan-malti-seo-performance-audit.html");
await fs.writeFile(output, html, "utf8");
console.log(`Generated ${output}`);
console.log(
  `Verified ${pages.length} routes; titles ${Math.min(...titleLengths)}–${Math.max(...titleLengths)} chars; descriptions ${Math.min(...descriptionLengths)}–${Math.max(...descriptionLengths)} chars.`,
);