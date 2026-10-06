<?php
/** Insurance enquiries — list + status */
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
require_admin();

$pdo = db();
if (!$pdo) exit('Database unavailable.');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_verify($_POST['csrf_token'] ?? null)) {
    $iid = (int) ($_POST['id'] ?? 0);
    $st  = in_array($_POST['status'] ?? '', ['new','contacted','closed'], true) ? $_POST['status'] : null;
    if ($iid && $st) {
        $pdo->prepare('UPDATE insurance_enquiries SET status = ? WHERE id = ?')->execute([$st, $iid]);
        audit_log('insurance_status', "Insurance enquiry #$iid → $st");
    }
    header('Location: ' . admin_url('insurance.php'));
    exit;
}

$rows = $pdo->query('SELECT * FROM insurance_enquiries ORDER BY created_at DESC LIMIT 200')->fetchAll();

$adminTitle = 'Insurance Enquiries';
$adminActive = 'insurance';
require __DIR__ . '/includes/header.php';
?>
<div class="card">
  <table>
    <thead><tr><th>Name</th><th>Mobile</th><th>Insurer / TPA</th><th>Type</th><th>Details</th><th>Status</th><th>Received</th><th></th></tr></thead>
    <tbody>
      <?php if (!$rows): ?><tr><td colspan="8" style="color:#7A858A;">No insurance enquiries yet.</td></tr><?php endif; ?>
      <?php foreach ($rows as $r): ?>
      <tr>
        <td><strong><?= e($r['name']) ?></strong></td>
        <td><a href="tel:<?= e($r['mobile']) ?>"><?= e($r['mobile']) ?></a></td>
        <td><?= e($r['insurer'] ?: '—') ?></td>
        <td><?= e(ucwords(str_replace('_', ' ', $r['admission_type']))) ?></td>
        <td style="max-width:260px;"><?= e(mb_strimwidth((string) $r['message'], 0, 120, '…')) ?></td>
        <td><span class="badge badge--<?= $r['status'] === 'new' ? 'new' : ($r['status'] === 'contacted' ? 'contacted' : 'completed') ?>"><?= e(ucfirst($r['status'])) ?></span></td>
        <td><?= e(date('d M y', strtotime($r['created_at']))) ?></td>
        <td>
          <form method="post" style="display:flex;gap:6px;">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
            <select name="status" style="padding:6px 8px;border:1px solid #DCE7EA;border-radius:8px;font-size:12.5px;">
              <?php foreach (['new','contacted','closed'] as $s): ?>
              <option value="<?= $s ?>" <?= $r['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
              <?php endforeach; ?>
            </select>
            <button class="btn btn--outline btn--sm">Save</button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
