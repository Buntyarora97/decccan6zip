<?php
/** Admin dashboard — counts + recent enquiries */
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
require_admin();

$pdo = db();
$counts = ['new' => 0, 'contacted' => 0, 'confirmed' => 0, 'completed' => 0, 'cancelled' => 0, 'follow_up' => 0];
$recent = [];
$unreadContacts = 0;
$subscribers = 0;

if ($pdo) {
    foreach ($pdo->query('SELECT status, COUNT(*) c FROM appointments GROUP BY status') as $row) {
        $counts[$row['status']] = (int) $row['c'];
    }
    $recent = $pdo->query('SELECT * FROM appointments ORDER BY created_at DESC LIMIT 8')->fetchAll();
    $unreadContacts = (int) $pdo->query('SELECT COUNT(*) FROM contact_enquiries WHERE is_read = 0')->fetchColumn();
    $subscribers = (int) $pdo->query('SELECT COUNT(*) FROM newsletter_subscribers')->fetchColumn();
}

$adminTitle = 'Dashboard';
$adminActive = 'dashboard';
require __DIR__ . '/includes/header.php';
?>
<div class="stat-grid">
  <div class="stat stat--accent"><span class="num"><?= $counts['new'] ?></span><span class="lbl">New Requests</span></div>
  <div class="stat"><span class="num"><?= $counts['contacted'] ?></span><span class="lbl">Contacted</span></div>
  <div class="stat"><span class="num"><?= $counts['confirmed'] ?></span><span class="lbl">Confirmed</span></div>
  <div class="stat"><span class="num"><?= $counts['completed'] ?></span><span class="lbl">Completed</span></div>
  <div class="stat"><span class="num"><?= $counts['follow_up'] ?></span><span class="lbl">Follow-up</span></div>
  <div class="stat"><span class="num"><?= $counts['cancelled'] ?></span><span class="lbl">Cancelled</span></div>
  <div class="stat"><span class="num"><?= $unreadContacts ?></span><span class="lbl">Unread Enquiries</span></div>
  <div class="stat"><span class="num"><?= $subscribers ?></span><span class="lbl">Subscribers</span></div>
</div>

<div class="card">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
    <h2 style="font-size:18px;">Recent appointment requests</h2>
    <a href="<?= e(admin_url('appointments.php')) ?>" class="btn btn--outline btn--sm">View all</a>
  </div>
  <?php if (!$recent): ?>
  <p style="color:#7A858A;font-size:14px;">No appointment requests yet. New requests will appear here.</p>
  <?php else: ?>
  <table>
    <thead><tr><th>Ref</th><th>Patient</th><th>Department</th><th>Preferred</th><th>Status</th><th>Received</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($recent as $r): ?>
      <tr>
        <td><strong><?= e($r['ref_no']) ?></strong></td>
        <td><?= e($r['patient_name']) ?><br><small style="color:#7A858A;"><?= e($r['mobile']) ?></small></td>
        <td><?= e($r['department']) ?></td>
        <td><?= e($r['preferred_date'] ?: '—') ?> <?= e($r['preferred_time'] ?: '') ?></td>
        <td><span class="badge badge--<?= e($r['status']) ?>"><?= e(ucwords(str_replace('_', ' ', $r['status']))) ?></span></td>
        <td><?= e(date('d M, h:i A', strtotime($r['created_at']))) ?></td>
        <td><a href="<?= e(admin_url('appointment-view.php?id=' . (int) $r['id'])) ?>" class="btn btn--outline btn--sm">Open</a></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
