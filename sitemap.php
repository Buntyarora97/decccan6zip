<?php
/**
 * Dynamic XML sitemap — /sitemap.xml (.htaccess rewrite se)
 */
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';

header('Content-Type: application/xml; charset=utf-8');

$urls = [
    ['', '1.0', 'weekly'],
    ['about', '0.8', 'monthly'],
    ['leadership', '0.7', 'monthly'],
    ['doctors', '0.8', 'weekly'],
    ['departments', '0.9', 'weekly'],
    ['facilities', '0.6', 'monthly'],
    ['patient-care', '0.7', 'monthly'],
    ['insurance', '0.7', 'monthly'],
    ['testimonials', '0.5', 'monthly'],
    ['gallery', '0.4', 'monthly'],
    ['health-library', '0.7', 'weekly'],
    ['faqs', '0.6', 'monthly'],
    ['contact', '0.8', 'monthly'],
    ['appointment', '0.9', 'monthly'],
    ['privacy-policy', '0.2', 'yearly'],
    ['terms-conditions', '0.2', 'yearly'],
    ['medical-disclaimer', '0.2', 'yearly'],
];

foreach (array_keys(dm_departments()) as $slug) {
    $urls[] = ['departments/' . $slug, '0.9', 'monthly'];
}
foreach (dm_doctors() as $slug => $doc) {
    if (!empty($doc['published'])) $urls[] = ['doctors/' . $slug, '0.8', 'monthly'];
}
foreach (dm_articles() as $slug => $a) {
    $urls[] = ['health-library/' . $slug, '0.6', 'monthly', $a['updated']];
}
foreach (array_keys(dm_patient_care_pages()) as $slug) {
    $urls[] = ['patient-care/' . $slug, '0.6', 'monthly'];
}

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach ($urls as $u) {
    [$loc, $priority, $freq] = $u;
    $lastmod = isset($u[3]) ? '<lastmod>' . e($u[3]) . '</lastmod>' : '';
    echo '  <url>'
        . '<loc>' . e(dm_url($loc)) . '</loc>'
        . $lastmod
        . '<changefreq>' . e($freq) . '</changefreq>'
        . '<priority>' . e($priority) . '</priority>'
        . '</url>' . "\n";
}
echo '</urlset>';
