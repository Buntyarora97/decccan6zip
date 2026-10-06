<?php
/**
 * Shared helper functions — escaping, CSRF, validation, rate limiting.
 */
declare(strict_types=1);

/** HTML escape */
function e(?string $str): string
{
    return htmlspecialchars((string) $str, ENT_QUOTES, 'UTF-8');
}

/** Current page URL path (without leading slash) */
function dm_path(): string
{
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    // Agar site subfolder mein ho toh base hatao
    $script = dirname($_SERVER['SCRIPT_NAME'] ?? '/');
    if ($script !== '/' && $script !== '\\' && strpos($path, $script) === 0) {
        $path = substr($path, strlen($script));
    }
    return trim($path, '/');
}

/** Absolute URL */
function dm_url(string $path = ''): string
{
    return rtrim(SITE_URL, '/') . '/' . ltrim($path, '/');
}

/** CSRF token generate/return */
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/** CSRF hidden input */
function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

/** CSRF verify */
function csrf_verify(?string $token): bool
{
    return is_string($token)
        && !empty($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $token);
}

/** Simple session-based rate limit: $max requests per $seconds window */
function rate_limited(string $bucket, int $max = 5, int $seconds = 300): bool
{
    $now = time();
    $_SESSION['rl'][$bucket] = array_filter(
        $_SESSION['rl'][$bucket] ?? [],
        fn($t) => ($now - (int) $t) < $seconds
    );
    if (count($_SESSION['rl'][$bucket]) >= $max) {
        return true;
    }
    $_SESSION['rl'][$bucket][] = $now;
    return false;
}

/** Clean text input */
function clean(string $value, int $max = 500): string
{
    $value = trim($value);
    $value = strip_tags($value);
    return mb_substr($value, 0, $max);
}

/** Validate Indian mobile (10 digit, optional +91) */
function valid_mobile(string $mobile): bool
{
    $digits = preg_replace('/\D/', '', $mobile);
    if (strlen($digits) === 12 && str_starts_with($digits, '91')) {
        $digits = substr($digits, 2);
    }
    return (bool) preg_match('/^[6-9]\d{9}$/', $digits);
}

/** JSON response + exit */
function json_response(array $data, int $code = 200): void
{
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

/** Human readable reference number e.g. DMH-2026-8F3K2 */
function make_ref_no(string $prefix = 'DMH'): string
{
    $rand = strtoupper(bin2hex(random_bytes(3)));
    return $prefix . '-' . date('Y') . '-' . $rand;
}

/** Client IP */
function client_ip(): string
{
    return substr((string) ($_SERVER['REMOTE_ADDR'] ?? ''), 0, 45);
}

/** Log email send result */
function log_email(string $to, string $subject, string $type, bool $ok, string $error = ''): void
{
    $pdo = db();
    if (!$pdo) return;
    try {
        $stmt = $pdo->prepare(
            'INSERT INTO email_logs (to_email, subject, mail_type, status, error) VALUES (?,?,?,?,?)'
        );
        $stmt->execute([$to, $subject, $type, $ok ? 'sent' : 'failed', $error ?: null]);
    } catch (Throwable $e) {
        error_log('email log failed: ' . $e->getMessage());
    }
}

/** Admin audit log */
function audit_log(string $action, string $details = ''): void
{
    $pdo = db();
    if (!$pdo) return;
    try {
        $stmt = $pdo->prepare(
            'INSERT INTO admin_audit_logs (admin_id, action, details, ip_address) VALUES (?,?,?,?)'
        );
        $stmt->execute([$_SESSION['admin_id'] ?? null, $action, $details, client_ip()]);
    } catch (Throwable $e) {
        error_log('audit log failed: ' . $e->getMessage());
    }
}

/** Icon SVG (fine medical line icons) — stroke based, currentColor */
function icon(string $name, string $class = 'icon'): string
{
    static $icons = null;
    if ($icons === null) {
        $icons = require __DIR__ . '/../data/icons.php';
    }
    $path = $icons[$name] ?? $icons['default'];
    return '<svg class="' . e($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $path . '</svg>';
}

/** Official-colour social marks; whitelist only to keep embedded SVG static. */
function dm_social_icon(string $name): string
{
    $icons = [
        'facebook' => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="11" fill="#0866FF"/><path d="M13.45 20v-7h2.4l.36-2.72h-2.76V8.54c0-.79.23-1.33 1.38-1.33h1.48V4.78c-.72-.08-1.44-.12-2.17-.12-2.15 0-3.62 1.31-3.62 3.72v1.9H8.1V13h2.42v7z" fill="#fff"/></svg>',
        'instagram' => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="11" fill="#C13584"/><rect x="4.4" y="4.4" width="15.2" height="15.2" rx="4.5" fill="none" stroke="#fff" stroke-width="2"/><circle cx="12" cy="12" r="3.45" fill="none" stroke="#fff" stroke-width="2"/><circle cx="17.25" cy="6.9" r="1.05" fill="#fff"/></svg>',
        'x' => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="11" fill="#111"/><path d="M7 6h2.7l7.3 12h-2.7L7 6zm9.8 0h2.1l-8.7 12H8.1L16.8 6z" fill="#fff"/></svg>',
        'youtube' => '<svg viewBox="0 0 24 24" aria-hidden="true"><rect x="1" y="4" width="22" height="16" rx="4" fill="#FF0033"/><path d="M10 8.2v7.6L16.5 12 10 8.2z" fill="#fff"/></svg>',
        'whatsapp' => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="11" fill="#25D366"/><path d="M8 7.2c.4-.3.9-.1 1.1.3l.9 1.9c.2.4.1.7-.2 1l-.7.7c.5 1.2 1.4 2.1 2.6 2.7l.7-.8c.3-.3.6-.4 1-.2l1.9.9c.4.2.6.7.4 1.1-.4 1-1.4 1.6-2.5 1.5-3.8-.4-6.7-3.3-7-7.1-.1-.9.7-1.7 1.8-2z" fill="#fff"/></svg>',
    ];
    return $icons[$name] ?? '';
}

/** Responsive image helper */
function dm_img(string $src, string $alt, int $w, int $h, string $class = '', bool $eager = false): string
{
    $loading = $eager ? 'eager' : 'lazy';
    $fetch   = $eager ? ' fetchpriority="high"' : '';
    return '<img src="' . e(dm_url($src)) . '" alt="' . e($alt) . '" width="' . $w . '" height="' . $h
        . '" loading="' . $loading . '" decoding="async"' . $fetch
        . ($class ? ' class="' . e($class) . '"' : '') . '>';
}
