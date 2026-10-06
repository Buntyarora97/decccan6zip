<?php
/**
 * Robots policy with sitemap URL generated from the configured site host.
 */
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

header('Content-Type: text/plain; charset=utf-8');
echo "User-agent: *\n";
echo "Allow: /\n";
echo "Disallow: /admin/\n";
echo "Disallow: /api/\n";
echo "Disallow: /config/\n";
echo "Disallow: /includes/\n";
echo "Disallow: /data/\n";
echo "Disallow: /attached_assets/\n";
echo "Sitemap: " . dm_url('sitemap.xml') . "\n";