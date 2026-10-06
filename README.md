# Deccan Malti Neuro & Superspeciality Hospital — Website

Complete production website for shared hosting: **Core PHP 8.1+ · MySQL 8 / MariaDB · Vanilla JS · GSAP + Swiper (CDN)**. No frameworks, no build step.

## Kya-kya included hai

| Area | Details |
|---|---|
| Pages | Home (12 sections), About (8 sections), 10 department pages (2,000+ words each + FAQs), Doctors directory + 2 verified profiles, Leadership, Facilities, Patient Care hub + 5 sub-pages, Insurance, Testimonials, Gallery, Health Library + 6 articles, FAQs, Contact, Privacy, Terms, Medical Disclaimer, custom 404 |
| Forms | Appointment, Contact, Insurance eligibility, Newsletter — sab AJAX + CSRF + honeypot + rate limiting + PDO prepared statements |
| Admin | `/admin` — secure login (throttled), dashboard, appointment management (status pipeline, notes, CSV export, email replies), contact enquiries, insurance enquiries, newsletter, SMTP settings, audit log |
| SEO | Clean URLs, meta + OG tags per page, JSON-LD (Hospital, Breadcrumb, Physician, FAQ, Article), dynamic sitemap.xml, robots.txt, 301 redirects from old URLs |
| Security | PDO prepared statements, output escaping, CSRF tokens, session hardening, login throttling, security headers, config outside web rules |

## Quick start (5 minute)

1. **Upload** — ZIP ke saare files apne hosting ke `public_html/` mein upload karein.
2. **Database** — cPanel → MySQL Databases: database + user banayein. phpMyAdmin → `database.sql` import karein.
3. **Config** — `config/config.example.php` ko copy karke `config.php` banayein aur DB + SMTP details bharein.
4. **Admin** — Browser mein `yourdomain.com/admin/setup.php` kholein aur pehla admin account banayein (yeh page sirf ek baar chalta hai).
5. **Done** — site live hai. Admin: `yourdomain.com/admin`.

Detailed steps: **DEPLOYMENT-GUIDE.md** · Images replace karne ki list: **IMAGE-MANIFEST.md**

## Structure

```
├── index.php              Front controller / router
├── .htaccess              Clean URLs, HTTPS, headers, caching, redirects
├── config/                config.php (yahan secrets)
├── includes/              bootstrap, db, functions, mailer, seo, layout
├── data/                  site facts, departments, doctors, articles, icons
├── pages/                 Saare page templates
├── api/                   Form endpoints (appointment/contact/insurance/newsletter)
├── admin/                 Secure admin panel
├── assets/                css / js / img
├── database.sql           MySQL schema (phpMyAdmin import)
├── sitemap.php            Dynamic XML sitemap (/sitemap.xml)
└── robots.txt
```

## Launch se pehle (zaroori)

- [ ] `config.php` mein SITE_URL, DB, SMTP set karein
- [ ] `robots.txt` mein `example.com` → apna domain
- [ ] Approved doctor portraits add karein; current doctor cards use a real hospital welcome photograph until portraits are supplied
- [ ] `[VERIFY ...]` tokens site mein search karke saaf karein
- [ ] Google Maps embed mein exact location confirm karein
- [ ] SSL certificate active karein (Let's Encrypt free hota hai)
