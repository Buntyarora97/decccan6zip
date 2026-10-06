<?php
/**
 * Deccan Malti Hospital — Configuration (EXAMPLE)
 * ---------------------------------------------------------------
 * 1. Is file ko "config.php" naam se copy karein (same folder mein).
 * 2. Neeche apne hosting ke details bharein.
 * 3. config.php ko kabhi kisi ko share na karein — isme secrets hain.
 *
 * Shared hosting (cPanel/Hostinger/MilesWeb):
 *   - cPanel > MySQL Databases mein database + user banayein
 *   - phpMyAdmin mein database.sql import karein
 *   - Yahan DB_HOST/DB_NAME/DB_USER/DB_PASS update karein
 */

// ---------- Database ----------
// Replit/shared hosting dono ke liye environment variables support.
// Local/shared-host fallback values ko production credentials se replace karein.
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'u575969915_deconhospital');
define('DB_USER', getenv('DB_USER') ?: 'u575969915_deconhospital');
define('DB_PASS', getenv('DB_PASS') ?: 'Bunty@#000#@');
define('DB_CHARSET', 'utf8mb4');


// ---------- Site ----------
// Trailing slash ke bina. Replit/shared hosting request host se automatic.
$configuredSiteUrl = trim((string) (getenv('SITE_URL') ?: ''));
if ($configuredSiteUrl === '') {
    $forwardedProto = strtolower((string) ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? ''));
    $isHttps = $forwardedProto === 'https'
        || (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    $scheme = $isHttps ? 'https' : 'http';
    $host = (string) ($_SERVER['HTTP_HOST'] ?? 'localhost');
    $configuredSiteUrl = $scheme . '://' . ($host !== '' ? $host : 'localhost');
}
define('SITE_URL', rtrim($configuredSiteUrl, '/'));
define('SITE_NAME', 'Deccan Malti Neuro & Superspeciality Hospital');

// ---------- SMTP (forms ke emails ke liye) ----------
// cPanel email account ya transactional SMTP use karein.
// Yeh values admin panel > Settings se bhi set ho sakti hain;
// admin panel ki values in defaults ko override karti hain.
define('SMTP_HOST', getenv('SMTP_HOST') ?: 'mail.example.com');
define('SMTP_PORT', (int) (getenv('SMTP_PORT') ?: 587)); // 587 = TLS, 465 = SSL
define('SMTP_USER', getenv('SMTP_USER') ?: 'website@example.com');
define('SMTP_PASS', getenv('SMTP_PASS') ?: '');
define('SMTP_SECURE', getenv('SMTP_SECURE') ?: 'tls');   // 'tls' ya 'ssl'
define('SMTP_FROM_EMAIL', getenv('SMTP_FROM_EMAIL') ?: 'website@example.com');
define('SMTP_FROM_NAME', 'Deccan Malti Hospital Website');

// Form submissions kis email par aayein
define('HOSPITAL_NOTIFY_EMAIL', getenv('HOSPITAL_NOTIFY_EMAIL') ?: '');

// ---------- Environment ----------
// 'production' mein errors display off; 'development' mein on
define('APP_ENV', 'production');
