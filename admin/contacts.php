<?php
/** Contact enquiries — list, mark read */
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
require_admin();

$pdo = db();
if (!$pdo) exit('Database unavailable.');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_verify($_POST['csrf_token'] ?? null)) {
    $cid = (int) ($_POST['id'] ?? 0);
    if ($cid && isset($_POST['toggle_read'])) {
        $pdo->prepare('UPDATE contact_enquiries SET is_read = 1 - is_read WHERE id = ?')->execute([$cid]);
    }
    header('Location: ' . admin_url('contacts.php'));
    exit;
}

$rows = $pdo->query('SELECT * FROM contact_enquiries ORDER BY created_at DESC LIMIT 200')->fetchAll();

$adminTitle = 'Contact Enquiries';
$adminActive = 'contacts';
require __DIR__ . '/includes/header.php';
?>
<div class="card">
  <table>
    <thead><tr><th>From</th><th>Contact</th><th>Department</th><th>Message</th><th>Received</th><th></th></tr></thead>
    <tbody>
      <?php if (!$rows): ?><tr><td colspan="6" style="color:#7A858A;">No enquiries yet.</td></tr><?php endif; ?>
      <?php foreach ($rows as $r): ?>
      <tr style="<?= $r['is_read'] ? '' : 'background:#FFFBF0;' ?>">
        <td><strong><?= e($r['name']) ?></strong><br><small style="color:#7A858A;"><?= e($r['subject'] ?: '') ?></small></td>
        <td><?= e($r['phone'] ?: '') ?><br><small style="color:#7A858A;"><?= e($r['email'] ?: '') ?></small></td>
        <td><?= e($r['department'] ?: '—') ?></td>
        <td style="max-width:320px;"><?= nl2br(e(mb_strimwidth($r['message'], 0, 180, '…'))) ?></td>
        <td><?= e(date('d M y, h:i A', strtotime($r['created_at']))) ?></td>
        <td>
          <form method="post" style="display:inline;">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
            <button name="toggle_read" class="btn btn--outline btn--sm"><?= $r['is_read'] ? 'Mark unread' : 'Mark read' ?></button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
