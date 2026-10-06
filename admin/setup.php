<?php
/**
 * First-admin setup — SIRF tab chalta hai jab koi admin user na ho.
 * Pehla admin banane ke baad yeh page apne aap band ho jata hai.
 * SECURITY: setup complete hone par is file ka access block ho jata hai.
 */
declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';

$pdo = db();
if (!$pdo) {
    exit('Database connection failed. Check config/config.php first.');
}

// Koi admin already hai? Toh setup closed.
$count = (int) $pdo->query('SELECT COUNT(*) FROM admin_users')->fetchColumn();
if ($count > 0) {
    exit('Setup is closed. An administrator account already exists. <a href="' . e(admin_url('index.php')) . '">Log in</a>.');
}

$msg = '';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify($_POST['csrf_token'] ?? null)) {
        $err = 'Session expired. Try again.';
    } else {
        $name  = clean($_POST['name'] ?? '', 120);
        $email = clean($_POST['email'] ?? '', 190);
        $pass  = (string) ($_POST['password'] ?? '');
        $pass2 = (string) ($_POST['password2'] ?? '');

        if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $err = 'Please enter a valid name and email.';
        } elseif (strlen($pass) < 10) {
            $err = 'Password must be at least 10 characters.';
        } elseif ($pass !== $pass2) {
            $err = 'Passwords do not match.';
        } else {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO admin_users (name, email, password_hash, role) VALUES (?,?,?,?)');
            $stmt->execute([$name, $email, $hash, 'admin']);
            audit_log('setup', 'First admin created: ' . $email);
            $msg = 'Admin account created. You can now <a href="' . e(admin_url('index.php')) . '">log in</a>. This setup page is now permanently closed.';
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
<title>Setup — Deccan Malti Admin</title>
<link rel="icon" type="image/webp" href="<?= e(dm_url('assets/img/favicon-brand.webp')) ?>">
<link rel="stylesheet" href="<?= e(dm_url('admin/assets/admin.css')) ?>?v=1.0.4">
</head>
<body>
<div class="login-wrap">
  <form class="login-card" method="post">
    <?= csrf_field() ?>
    <h1>First-time Setup</h1>
    <p>Create the first administrator account. This page works only once.</p>
    <?php if ($err): ?><div class="alert alert--err"><?= e($err) ?></div><?php endif; ?>
    <?php if ($msg): ?><div class="alert alert--ok"><?= $msg ?></div><?php endif; ?>
    <?php if (!$msg): ?>
    <div class="form-row"><label for="name">Full Name</label><input type="text" id="name" name="name" required></div>
    <div class="form-row"><label for="email">Email</label><input type="email" id="email" name="email" required></div>
    <div class="form-row"><label for="password">Password (min 10 characters)</label><input type="password" id="password" name="password" required minlength="10"></div>
    <div class="form-row"><label for="password2">Confirm Password</label><input type="password" id="password2" name="password2" required minlength="10"></div>
    <button type="submit" class="btn btn--primary" style="width:100%;justify-content:center;">Create Admin Account</button>
    <?php endif; ?>
  </form>
</div>
</body>
</html>
