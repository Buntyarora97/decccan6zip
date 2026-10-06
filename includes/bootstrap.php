<?php
/**
 * Bootstrap — har entry point (index.php, api/*, admin/*) isi se start hota hai.
 */
declare(strict_types=1);

// ---------- Config ----------
$configFile = __DIR__ . '/../config/config.php';
if (!file_exists($configFile)) {
    $configFile = __DIR__ . '/../config/config.example.php'; // fallback (defaults)
}
require_once $configFile;

// ---------- Error handling ----------
if (defined('APP_ENV') && APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}

// ---------- Secure session ----------
function dm_start_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }
    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    session_name('DMSESSID');
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => $secure,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

// ---------- Core includes ----------
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/mailer.php';
require_once __DIR__ . '/../data/departments.php';
require_once __DIR__ . '/../data/doctors.php';
require_once __DIR__ . '/../data/articles.php';
require_once __DIR__ . '/../data/site.php';

dm_start_session();
