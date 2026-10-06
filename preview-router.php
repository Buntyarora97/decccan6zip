<?php
/**
 * Replit/local preview router.
 *
 * Apache uses .htaccess in shared hosting. PHP's built-in server does not
 * read .htaccess, so this small router sends clean URLs to index.php while
 * allowing real assets, APIs and admin files to be served normally.
 */
declare(strict_types=1);

$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$requestPath = rawurldecode($requestPath);

// Never expose project internals, uploaded originals, or repository metadata
// through the PHP development server (which does not read Apache .htaccess).
$blocked = [
    '#^/(?:config|data|includes|attached_assets|\.git|\.agents|\.local|\.cache)(?:/|$)#i',
    '#^/(?:database\.sql|zipFile\.zip|\.replit|\.gitignore|\.gitattributes)(?:$|/)#i',
];
foreach ($blocked as $pattern) {
    if (preg_match($pattern, $requestPath)) {
        http_response_code(404);
        exit;
    }
}

if ($requestPath === '/sitemap.xml') {
    require __DIR__ . '/sitemap.php';
    return;
}
if ($requestPath === '/robots.txt') {
    require __DIR__ . '/robots.php';
    return;
}

$requestedFile = __DIR__ . $requestPath;
if ($requestPath !== '/' && (is_file($requestedFile) || is_dir($requestedFile))) {
    return false;
}

require __DIR__ . '/index.php';