<?php
/** Newsletter subscribers — list + CSV export */
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
require_admin();

$pdo = db();
if (!$pdo) exit('Database unavailable.');

if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    audit_log('export_csv', 'Newsletter subscribers exported');
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="newsletter-' . date('Y-m-d') . '.csv"');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['Email', 'Subscribed']);
    foreach ($pdo->query('SELECT email, created_at FROM newsletter_subscribers ORDER BY created_at DESC') as $row) {
        fputcsv($out, $row);
    }
    fclose($out);
    exit;
}

$rows = $pdo->query('SELECT * FROM newsletter_subscribers ORDER BY created_at DESC LIMIT 500')->fetchAll();

$adminTitle = 'Newsletter Subscribers';
$adminActive = 'newsletter';
require __DIR__ . '/includes/header.php';
?>
<div class="card">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
    <p style="font-size:14px;color:#7A858A;"><?= count($rows) ?> subscriber(s)</p>
    <a href="<?= e(admin_url('newsletter.php?export=csv')) ?>" class="btn btn--accent btn--sm">Export CSV</a>
  </div>
  <table>
    <thead><tr><th>Email</th><th>Subscribed</th></tr></thead>
    <tbody>
      <?php if (!$rows): ?><tr><td colspan="2" style="color:#7A858A;">No subscribers yet.</td></tr><?php endif; ?>
      <?php foreach ($rows as $r): ?>
      <tr><td><?= e($r['email']) ?></td><td><?= e(date('d M Y', strtotime($r['created_at']))) ?></td></tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
