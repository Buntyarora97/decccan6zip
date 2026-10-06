<?php
/**
 * PDO database connection (singleton).
 * DB available na ho toh site ke public pages phir bhi chalte hain —
 * sirf forms/admin ko DB chahiye, isliye db() null bhi return kar sakta hai.
 */
declare(strict_types=1);

function db(): ?PDO
{
    static $pdo = null;
    static $tried = false;

    if ($pdo instanceof PDO) {
        return $pdo;
    }
    if ($tried) {
        return null;
    }
    $tried = true;

    try {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
        return $pdo;
    } catch (Throwable $e) {
        error_log('DB connection failed: ' . $e->getMessage());
        return null;
    }
}

/** Simple setting getter (DB settings table). */
function dm_setting(string $key, string $default = ''): string
{
    static $cache = null;
    if ($cache === null) {
        $cache = [];
        $pdo = db();
        if ($pdo) {
            try {
                foreach ($pdo->query('SELECT skey, svalue FROM settings') as $row) {
                    $cache[$row['skey']] = (string) $row['svalue'];
                }
            } catch (Throwable $e) {
                // table may not exist yet
            }
        }
    }
    return ($cache[$key] ?? '') !== '' ? (string) $cache[$key] : $default;
}
