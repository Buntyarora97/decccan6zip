<?php
/** Appointments list — search, filters, pagination, CSV export */
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
require_admin();

$pdo = db();
if (!$pdo) exit('Database unavailable.');

$q      = clean($_GET['q'] ?? '', 100);
$status = in_array($_GET['status'] ?? '', ['new','contacted','confirmed','completed','cancelled','follow_up'], true) ? $_GET['status'] : '';
$dept   = clean($_GET['department'] ?? '', 80);
$from   = preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['from'] ?? '') ? $_GET['from'] : '';
$to     = preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['to'] ?? '') ? $_GET['to'] : '';
$page   = max(1, (int) ($_GET['page'] ?? 1));
$per    = 20;

$where = [];
$args  = [];
if ($q !== '')      { $where[] = '(patient_name LIKE ? OR mobile LIKE ? OR ref_no LIKE ? OR email LIKE ?)'; $args = array_merge($args, ["%$q%","%$q%","%$q%","%$q%"]); }
if ($status !== '') { $where[] = 'status = ?'; $args[] = $status; }
if ($dept !== '')   { $where[] = 'department = ?'; $args[] = $dept; }
if ($from !== '')   { $where[] = 'created_at >= ?'; $args[] = $from . ' 00:00:00'; }
if ($to !== '')     { $where[] = 'created_at <= ?'; $args[] = $to . ' 23:59:59'; }
$whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// ---------- CSV export ----------
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    $stmt = $pdo->prepare("SELECT ref_no, patient_name, mobile, email, age, department, doctor, preferred_date, preferred_time, patient_type, status, message, created_at FROM appointments $whereSql ORDER BY created_at DESC");
    $stmt->execute($args);
    audit_log('export_csv', 'Appointments exported (' . count($args) . ' filters)');
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="appointments-' . date('Y-m-d') . '.csv"');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['Ref','Patient','Mobile','Email','Age','Department','Doctor','Preferred Date','Time','Type','Status','Message','Received']);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) fputcsv($out, $row);
    fclose($out);
    exit;
}

$countStmt = $pdo->prepare("SELECT COUNT(*) FROM appointments $whereSql");
$countStmt->execute($args);
$total = (int) $countStmt->fetchColumn();
$pages = max(1, (int) ceil($total / $per));
$page  = min($page, $pages);

$listStmt = $pdo->prepare("SELECT * FROM appointments $whereSql ORDER BY created_at DESC LIMIT $per OFFSET " . (($page - 1) * $per));
$listStmt->execute($args);
$rows = $listStmt->fetchAll();

$deptList = dm_departments();
$queryBase = http_build_query(array_filter(['q' => $q, 'status' => $status, 'department' => $dept, 'from' => $from, 'to' => $to]));

$adminTitle = 'Appointments';
$adminActive = 'appointments';
require __DIR__ . '/includes/header.php';
?>
<form class="filters" method="get">
  <input type="search" name="q" value="<?= e($q) ?>" placeholder="Search name / mobile / ref…">
  <select name="status">
    <option value="">All statuses</option>
    <?php foreach (['new','contacted','confirmed','completed','cancelled','follow_up'] as $s): ?>
    <option value="<?= $s ?>" <?= $status === $s ? 'selected' : '' ?>><?= ucwords(str_replace('_',' ',$s)) ?></option>
    <?php endforeach; ?>
  </select>
  <select name="department">
    <option value="">All departments</option>
    <?php foreach ($deptList as $slug => $d): ?>
    <option value="<?= e($slug) ?>" <?= $dept === $slug ? 'selected' : '' ?>><?= e($d['name']) ?></option>
    <?php endforeach; ?>
  </select>
  <input type="date" name="from" value="<?= e($from) ?>" aria-label="From date">
  <input type="date" name="to" value="<?= e($to) ?>" aria-label="To date">
  <button type="submit" class="btn btn--primary btn--sm">Filter</button>
  <a href="<?= e(admin_url('appointments.php')) ?>" class="btn btn--outline btn--sm">Reset</a>
  <a href="<?= e(admin_url('appointments.php?' . $queryBase . '&export=csv')) ?>" class="btn btn--accent btn--sm">Export CSV</a>
</form>

<div class="card">
  <p style="font-size:13px;color:#7A858A;margin-bottom:12px;"><?= $total ?> record(s) found.</p>
  <table>
    <thead><tr><th>Ref</th><th>Patient</th><th>Contact</th><th>Department</th><th>Doctor</th><th>Preferred</th><th>Status</th><th>Received</th><th></th></tr></thead>
    <tbody>
      <?php if (!$rows): ?>
      <tr><td colspan="9" style="color:#7A858A;">No records match your filters.</td></tr>
      <?php endif; ?>
      <?php foreach ($rows as $r): ?>
      <tr>
        <td><strong><?= e($r['ref_no']) ?></strong></td>
        <td><?= e($r['patient_name']) ?><?= $r['age'] ? ' (' . (int) $r['age'] . ')' : '' ?></td>
        <td><?= e($r['mobile']) ?><?= $r['email'] ? '<br><small style="color:#7A858A;">' . e($r['email']) . '</small>' : '' ?></td>
        <td><?= e($r['department']) ?></td>
        <td><?= e($r['doctor'] ?: '—') ?></td>
        <td><?= e($r['preferred_date'] ?: '—') ?><br><small style="color:#7A858A;"><?= e($r['preferred_time'] ?: '') ?></small></td>
        <td><span class="badge badge--<?= e($r['status']) ?>"><?= e(ucwords(str_replace('_', ' ', $r['status']))) ?></span></td>
        <td><?= e(date('d M y, h:i A', strtotime($r['created_at']))) ?></td>
        <td><a href="<?= e(admin_url('appointment-view.php?id=' . (int) $r['id'])) ?>" class="btn btn--outline btn--sm">Open</a></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php if ($pages > 1): ?>
  <div class="pagination">
    <?php for ($p = 1; $p <= $pages; $p++): ?>
      <?php if ($p === $page): ?><span><?= $p ?></span>
      <?php else: ?><a href="<?= e(admin_url('appointments.php?' . $queryBase . '&page=' . $p)) ?>"><?= $p ?></a><?php endif; ?>
    <?php endfor; ?>
  </div>
  <?php endif; ?>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
