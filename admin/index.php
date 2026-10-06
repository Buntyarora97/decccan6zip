<?php
/**
 * Admin login — password_hash verify + throttling + session regeneration.
 */
declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';

if (admin_logged_in()) {
    header('Location: ' . admin_url('dashboard.php'));
    exit;
}

$error = '';
$timeoutMsg = !empty($_GET['timeout']) ? 'Your session expired. Please log in again.' : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify($_POST['csrf_token'] ?? null)) {
        $error = 'Session expired. Please try again.';
    } else {
        $email = clean($_POST['email'] ?? '', 190);
        $pass  = (string) ($_POST['password'] ?? '');

        if (login_throttled($email)) {
            $error = 'Too many failed attempts. Please wait 15 minutes and try again.';
        } else {
            $pdo = db();
            $user = null;
            if ($pdo) {
                $stmt = $pdo->prepare('SELECT * FROM admin_users WHERE email = ? AND is_active = 1 LIMIT 1');
                $stmt->execute([$email]);
                $user = $stmt->fetch();
            }
            if ($user && password_verify($pass, $user['password_hash'])) {
                record_login_attempt($email, true);
                session_regenerate_id(true);
                $_SESSION['admin_id']    = (int) $user['id'];
                $_SESSION['admin_email'] = $user['email'];
                $_SESSION['admin_name']  = $user['name'];
                $_SESSION['admin_last']  = time();
                $pdo->prepare('UPDATE admin_users SET last_login_at = NOW() WHERE id = ?')->execute([$user['id']]);
                audit_log('login', 'Admin logged in: ' . $email);
                header('Location: ' . admin_url('dashboard.php'));
                exit;
            }
            record_login_attempt($email, false);
            $error = 'Incorrect email or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex, nofollow">
<title>Admin Login — Deccan Malti Hospital</title>
<link rel="icon" type="image/webp" href="<?= e(dm_url('assets/img/favicon-brand.webp')) ?>">
<link rel="stylesheet" href="<?= e(dm_url('admin/assets/admin.css')) ?>?v=1.0.4">
</head>
<body>
<div class="login-wrap">
  <form class="login-card" method="post">
    <?= csrf_field() ?>
    <img src="<?= e(dm_url('assets/img/logo-mark.webp')) ?>" alt="Deccan Malti Hospital" width="52" height="52" style="border-radius:50%;background:#fff;">
    <h1>Admin Panel</h1>
    <p>Deccan Malti Neuro &amp; Superspeciality Hospital</p>
    <?php if ($error): ?><div class="alert alert--err"><?= e($error) ?></div><?php endif; ?>
    <?php if ($timeoutMsg): ?><div class="alert alert--err"><?= e($timeoutMsg) ?></div><?php endif; ?>
    <div class="form-row">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required autocomplete="username">
    </div>
    <div class="form-row">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required autocomplete="current-password">
    </div>
    <button type="submit" class="btn btn--primary" style="width:100%;justify-content:center;">Log in</button>
  </form>
</div>
</body>
</html>
