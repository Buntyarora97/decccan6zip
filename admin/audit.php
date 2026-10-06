<?php
/** Audit log viewer */
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
require_admin();

$pdo = db();
if (!$pdo) exit('Database unavailable.');

$rows = $pdo->query('SELECT l.*, u.name AS admin_name FROM admin_audit_logs l LEFT JOIN admin_users u ON u.id = l.admin_id ORDER BY l.created_at DESC LIMIT 300')->fetchAll();

$adminTitle = 'Audit Log';
$adminActive = 'audit';
require __DIR__ . '/includes/header.php';
?>
<div class="card">
  <p style="font-size:13px;color:#7A858A;margin-bottom:14px;">Logins, status changes, exports and settings changes — latest 300 events.</p>
  <table>
    <thead><tr><th>When</th><th>Admin</th><th>Action</th><th>Details</th><th>IP</th></tr></thead>
    <tbody>
      <?php if (!$rows): ?><tr><td colspan="5" style="color:#7A858A;">No events logged yet.</td></tr><?php endif; ?>
      <?php foreach ($rows as $r): ?>
      <tr>
        <td><?= e(date('d M y, h:i A', strtotime($r['created_at']))) ?></td>
        <td><?= e($r['admin_name'] ?? '—') ?></td>
        <td><span class="badge badge--contacted"><?= e($r['action']) ?></span></td>
        <td style="max-width:340px;"><?= e($r['details'] ?? '') ?></td>
        <td><small style="color:#7A858A;"><?= e($r['ip_address'] ?? '') ?></small></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
