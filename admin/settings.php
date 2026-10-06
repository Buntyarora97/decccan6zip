<?php
/** Settings — SMTP + notification email + change own password */
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
require_admin();

$pdo = db();
if (!$pdo) exit('Database unavailable.');

$msg = '';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify($_POST['csrf_token'] ?? null)) {
        $err = 'Session expired. Try again.';
    } else {
        $action = $_POST['action'] ?? '';

        if ($action === 'smtp') {
            $fields = ['smtp_host', 'smtp_port', 'smtp_user', 'smtp_pass', 'smtp_secure', 'smtp_from_email', 'smtp_from_name', 'hospital_notify_email'];
            $upd = $pdo->prepare('INSERT INTO settings (skey, svalue) VALUES (?, ?) ON DUPLICATE KEY UPDATE svalue = VALUES(svalue)');
            foreach ($fields as $f) {
                $val = clean($_POST[$f] ?? '', 255);
                // Khali password = purana rakho
                if ($f === 'smtp_pass' && $val === '') continue;
                $upd->execute([$f, $val]);
            }
            audit_log('settings_update', 'SMTP/notification settings updated');
            $msg = 'Settings saved.';
        }

        if ($action === 'password') {
            $current = (string) ($_POST['current_password'] ?? '');
            $new     = (string) ($_POST['new_password'] ?? '');
            $new2    = (string) ($_POST['new_password2'] ?? '');

            $stmt = $pdo->prepare('SELECT password_hash FROM admin_users WHERE id = ?');
            $stmt->execute([$_SESSION['admin_id']]);
            $row = $stmt->fetch();

            if (!$row || !password_verify($current, $row['password_hash'])) {
                $err = 'Current password is incorrect.';
            } elseif (strlen($new) < 10) {
                $err = 'New password must be at least 10 characters.';
            } elseif ($new !== $new2) {
                $err = 'New passwords do not match.';
            } else {
                $pdo->prepare('UPDATE admin_users SET password_hash = ? WHERE id = ?')
                    ->execute([password_hash($new, PASSWORD_DEFAULT), $_SESSION['admin_id']]);
                audit_log('password_change', 'Admin changed own password');
                session_regenerate_id(true);
                $msg = 'Password updated successfully.';
            }
        }

        if ($action === 'test_email') {
            $to = clean($_POST['test_email'] ?? '', 190);
            if (filter_var($to, FILTER_VALIDATE_EMAIL)) {
                // Settings fresh read karne ke liye — static cache ko bypass karne seedha query
                $ok = send_mail($to, 'SMTP test — Deccan Malti Hospital', email_template('SMTP Test Successful', '<p>If you received this, your SMTP settings are working correctly.</p>'), 'test');
                $msg = $ok ? "Test email sent to $to." : 'Test email failed. Check SMTP details (and see email logs).';
            } else {
                $err = 'Enter a valid email for the test.';
            }
        }
    }
}

// Fresh settings (cache bypass)
$settings = [];
foreach ($pdo->query('SELECT skey, svalue FROM settings') as $row) {
    $settings[$row['skey']] = $row['svalue'];
}
$sv = fn(string $k) => e($settings[$k] ?? '');

$adminTitle = 'Settings';
$adminActive = 'settings';
require __DIR__ . '/includes/header.php';
?>
<?php if ($msg): ?><div class="alert alert--ok"><?= e($msg) ?></div><?php endif; ?>
<?php if ($err): ?><div class="alert alert--err"><?= e($err) ?></div><?php endif; ?>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;align-items:start;">
  <div class="card">
    <h2 style="font-size:18px;margin-bottom:6px;">SMTP &amp; notifications</h2>
    <p style="font-size:13px;color:#7A858A;margin-bottom:16px;">Form emails inke through jaate hain. cPanel email account ya apne provider ke SMTP details bharein.</p>
    <form method="post">
      <?= csrf_field() ?>
      <input type="hidden" name="action" value="smtp">
      <div class="form-row"><label>SMTP Host</label><input type="text" name="smtp_host" value="<?= $sv('smtp_host') ?>" placeholder="mail.yourdomain.com"></div>
      <div class="form-row">
        <div><label>Port</label><input type="number" name="smtp_port" value="<?= $sv('smtp_port') ?: '587' ?>"></div>
        <div><label>Security</label>
          <select name="smtp_secure">
            <option value="tls" <?= $settings['smtp_secure'] === 'tls' ? 'selected' : '' ?>>TLS (port 587)</option>
            <option value="ssl" <?= $settings['smtp_secure'] === 'ssl' ? 'selected' : '' ?>>SSL (port 465)</option>
            <option value="none" <?= $settings['smtp_secure'] === 'none' ? 'selected' : '' ?>>None</option>
          </select>
        </div>
      </div>
      <div class="form-row"><label>SMTP Username</label><input type="text" name="smtp_user" value="<?= $sv('smtp_user') ?>" autocomplete="off"></div>
      <div class="form-row"><label>SMTP Password <small style="color:#7A858A;">(blank = keep current)</small></label><input type="password" name="smtp_pass" autocomplete="new-password"></div>
      <div class="form-row"><label>From Email</label><input type="email" name="smtp_from_email" value="<?= $sv('smtp_from_email') ?>"></div>
      <div class="form-row"><label>From Name</label><input type="text" name="smtp_from_name" value="<?= $sv('smtp_from_name') ?>"></div>
      <div class="form-row"><label>Hospital notification email <small style="color:#7A858A;">(form submissions yahan aayein)</small></label><input type="email" name="hospital_notify_email" value="<?= $sv('hospital_notify_email') ?>"></div>
      <button type="submit" class="btn btn--primary">Save settings</button>
    </form>
    <hr style="border:none;border-top:1px solid #E8F0F2;margin:20px 0;">
    <form method="post" style="display:flex;gap:10px;align-items:end;">
      <?= csrf_field() ?>
      <input type="hidden" name="action" value="test_email">
      <div class="form-row" style="margin:0;flex:1;"><label>Send test email to</label><input type="email" name="test_email" required placeholder="you@example.com"></div>
      <button type="submit" class="btn btn--outline">Send test</button>
    </form>
  </div>

  <div class="card">
    <h2 style="font-size:18px;margin-bottom:6px;">Change my password</h2>
    <p style="font-size:13px;color:#7A858A;margin-bottom:16px;">Strong password rakhein — kam se kam 10 characters.</p>
    <form method="post">
      <?= csrf_field() ?>
      <input type="hidden" name="action" value="password">
      <div class="form-row" style="grid-template-columns:1fr;"><label>Current password</label><input type="password" name="current_password" required autocomplete="current-password"></div>
      <div class="form-row" style="grid-template-columns:1fr;"><label>New password</label><input type="password" name="new_password" required minlength="10" autocomplete="new-password"></div>
      <div class="form-row" style="grid-template-columns:1fr;"><label>Confirm new password</label><input type="password" name="new_password2" required minlength="10" autocomplete="new-password"></div>
      <button type="submit" class="btn btn--primary">Update password</button>
    </form>
  </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
