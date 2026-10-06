<?php
/**
 * Admin auth — session check, login throttling, role helpers.
 */
declare(strict_types=1);

require_once __DIR__ . '/../../includes/bootstrap.php';

/** Admin logged in hai? */
function admin_logged_in(): bool
{
    return !empty($_SESSION['admin_id']) && !empty($_SESSION['admin_email']);
}

/** Login guard — har protected admin page ke top par */
function require_admin(): void
{
    if (!admin_logged_in()) {
        header('Location: ' . admin_url('index.php'));
        exit;
    }
    // Session timeout: 30 min inactivity
    $timeout = 1800;
    if (isset($_SESSION['admin_last']) && (time() - (int) $_SESSION['admin_last']) > $timeout) {
        admin_logout_cleanup();
        header('Location: ' . admin_url('index.php?timeout=1'));
        exit;
    }
    $_SESSION['admin_last'] = time();
}

function admin_logout_cleanup(): void
{
    unset($_SESSION['admin_id'], $_SESSION['admin_email'], $_SESSION['admin_name'], $_SESSION['admin_last']);
    session_regenerate_id(true);
}

function admin_url(string $path = ''): string
{
    return dm_url('admin/' . ltrim($path, '/'));
}

/** Failed-login throttle: 5 fails in 15 min = lock */
function login_throttled(string $email): bool
{
    $pdo = db();
    if (!$pdo) return false;
    $stmt = $pdo->prepare(
        "SELECT COUNT(*) FROM login_attempts
         WHERE (email = ? OR ip_address = ?) AND success = 0
         AND attempted_at > (NOW() - INTERVAL 15 MINUTE)"
    );
    $stmt->execute([$email, client_ip()]);
    return (int) $stmt->fetchColumn() >= 5;
}

function record_login_attempt(string $email, bool $success): void
{
    $pdo = db();
    if (!$pdo) return;
    $stmt = $pdo->prepare('INSERT INTO login_attempts (email, ip_address, success) VALUES (?,?,?)');
    $stmt->execute([$email, client_ip(), $success ? 1 : 0]);
}
