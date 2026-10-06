<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
if (admin_logged_in()) {
    audit_log('logout', 'Admin logged out: ' . ($_SESSION['admin_email'] ?? ''));
}
admin_logout_cleanup();
header('Location: ' . admin_url('index.php'));
exit;
