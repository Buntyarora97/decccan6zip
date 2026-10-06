<?php
/** Appointment detail — status change, notes, reply-by-email, assign, callback */
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
require_admin();

$pdo = db();
if (!$pdo) exit('Database unavailable.');

$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM appointments WHERE id = ?');
$stmt->execute([$id]);
$appt = $stmt->fetch();
if (!$appt) exit('Record not found.');

$msg = '';
$err = '';
$statuses = ['new','contacted','confirmed','completed','cancelled','follow_up'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify($_POST['csrf_token'] ?? null)) {
        $err = 'Session expired. Try again.';
    } else {
        $action = $_POST['action'] ?? '';

        if ($action === 'update') {
            $newStatus = in_array($_POST['status'] ?? '', $statuses, true) ? $_POST['status'] : $appt['status'];
            $assigned  = clean($_POST['assigned_to'] ?? '', 120);
            $callback  = preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['callback_date'] ?? '') ? $_POST['callback_date'] : null;

            $upd = $pdo->prepare('UPDATE appointments SET status = ?, assigned_to = ?, callback_date = ? WHERE id = ?');
            $upd->execute([$newStatus, $assigned ?: null, $callback, $id]);

            if ($newStatus !== $appt['status']) {
                $hist = $pdo->prepare('INSERT INTO appointment_status_history (appointment_id, old_status, new_status, note, changed_by) VALUES (?,?,?,?,?)');
                $hist->execute([$id, $appt['status'], $newStatus, clean($_POST['status_note'] ?? '', 255) ?: null, $_SESSION['admin_id']]);
                audit_log('status_change', "Appointment {$appt['ref_no']}: {$appt['status']} → $newStatus");
            }
            $msg = 'Record updated.';
            $stmt->execute([$id]);
            $appt = $stmt->fetch();
        }

        if ($action === 'add_note') {
            $note = clean($_POST['note'] ?? '', 2000);
            if ($note !== '') {
                $ins = $pdo->prepare('INSERT INTO admin_notes (appointment_id, admin_id, note) VALUES (?,?,?)');
                $ins->execute([$id, $_SESSION['admin_id'], $note]);
                $msg = 'Note added.';
            }
        }

        if ($action === 'reply_email' && !empty($appt['email'])) {
            $replyMsg = clean($_POST['reply_message'] ?? '', 3000);
            if ($replyMsg !== '') {
                $body = '<p>Dear ' . e($appt['patient_name']) . ',</p><p>' . nl2br(e($replyMsg)) . '</p>'
                      . '<p>Reference: <strong>' . e($appt['ref_no']) . '</strong></p>'
                      . '<p>Regards,<br>Deccan Malti Neuro &amp; Superspeciality Hospital, Sangli<br>' . e(DM_PHONE_DISPLAY) . '</p>';
                $ok = send_mail($appt['email'], 'Re: Your appointment request ' . $appt['ref_no'], email_template('Regarding your appointment request', $body), 'admin_reply');
                $msg = $ok ? 'Reply emailed to ' . $appt['email'] : 'Email could not be sent. Check SMTP settings.';
                audit_log('reply_email', 'Reply sent to ' . $appt['email'] . ' for ' . $appt['ref_no'] . ' — ' . ($ok ? 'sent' : 'failed'));
            }
        }
    }
}

$notes = $pdo->prepare('SELECT n.*, u.name AS admin_name FROM admin_notes n LEFT JOIN admin_users u ON u.id = n.admin_id WHERE n.appointment_id = ? ORDER BY n.created_at DESC');
$notes->execute([$id]);
$notes = $notes->fetchAll();

$history = $pdo->prepare('SELECT h.*, u.name AS admin_name FROM appointment_status_history h LEFT JOIN admin_users u ON u.id = h.changed_by WHERE h.appointment_id = ? ORDER BY h.created_at DESC');
$history->execute([$id]);
$history = $history->fetchAll();

$adminTitle = 'Appointment ' . $appt['ref_no'];
$adminActive = 'appointments';
require __DIR__ . '/includes/header.php';
?>
<?php if ($msg): ?><div class="alert alert--ok"><?= e($msg) ?></div><?php endif; ?>
<?php if ($err): ?><div class="alert alert--err"><?= e($err) ?></div><?php endif; ?>

<div style="display:grid;grid-template-columns:1.3fr 1fr;gap:18px;align-items:start;">
  <div>
    <div class="card" style="margin-bottom:18px;">
      <h2 style="font-size:18px;margin-bottom:16px;">Request details</h2>
      <dl class="kv">
        <dt>Reference</dt><dd><strong><?= e($appt['ref_no']) ?></strong></dd>
        <dt>Patient</dt><dd><?= e($appt['patient_name']) ?><?= $appt['age'] ? ' (' . (int) $appt['age'] . ' yrs)' : '' ?></dd>
        <dt>Mobile</dt><dd><a href="tel:<?= e($appt['mobile']) ?>"><?= e($appt['mobile']) ?></a> · <a href="https://wa.me/<?= e(preg_replace('/\D/', '', $appt['mobile'])) ?>" target="_blank" rel="noopener">WhatsApp</a></dd>
        <dt>Email</dt><dd><?= e($appt['email'] ?: '—') ?></dd>
        <dt>Department</dt><dd><?= e($appt['department']) ?></dd>
        <dt>Preferred doctor</dt><dd><?= e($appt['doctor'] ?: '—') ?></dd>
        <dt>Preferred slot</dt><dd><?= e($appt['preferred_date'] ?: '—') ?> <?= e($appt['preferred_time'] ?: '') ?></dd>
        <dt>Patient type</dt><dd><?= $appt['patient_type'] === 'new' ? 'New patient' : 'Follow-up' ?></dd>
        <dt>Message</dt><dd><?= $appt['message'] ? nl2br(e($appt['message'])) : '—' ?></dd>
        <dt>Source</dt><dd><?= e(trim(($appt['utm_source'] ?? '') . ' ' . ($appt['utm_medium'] ?? '') . ' ' . ($appt['utm_campaign'] ?? '')) ?: 'direct') ?></dd>
        <dt>Received</dt><dd><?= e(date('d M Y, h:i A', strtotime($appt['created_at']))) ?></dd>
        <dt>Consent</dt><dd><?= $appt['consent'] ? 'Given ✓' : 'Not recorded' ?></dd>
      </dl>
    </div>

    <div class="card" style="margin-bottom:18px;">
      <h2 style="font-size:18px;margin-bottom:14px;">Internal notes</h2>
      <?php foreach ($notes as $n): ?>
      <div class="note-item">
        <?= nl2br(e($n['note'])) ?>
        <small><?= e($n['admin_name'] ?? 'Admin') ?> · <?= e(date('d M y, h:i A', strtotime($n['created_at']))) ?></small>
      </div>
      <?php endforeach; ?>
      <?php if (!$notes): ?><p style="color:#7A858A;font-size:14px;margin-bottom:12px;">No notes yet.</p><?php endif; ?>
      <form method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="add_note">
        <div class="form-row" style="grid-template-columns:1fr;">
          <textarea name="note" rows="3" placeholder="Add an internal note (visible only to staff)…" required></textarea>
        </div>
        <button type="submit" class="btn btn--outline btn--sm">Add note</button>
      </form>
    </div>

    <div class="card">
      <h2 style="font-size:18px;margin-bottom:14px;">Status history</h2>
      <?php if (!$history): ?><p style="color:#7A858A;font-size:14px;">No status changes yet.</p><?php endif; ?>
      <?php foreach ($history as $h): ?>
      <div class="note-item" style="border-left-color:#006AC1;background:#F5F8FC;">
        <?= e(ucwords(str_replace('_',' ', $h['old_status'] ?? '—'))) ?> → <strong><?= e(ucwords(str_replace('_',' ', $h['new_status']))) ?></strong>
        <?= $h['note'] ? ' — ' . e($h['note']) : '' ?>
        <small><?= e($h['admin_name'] ?? 'System') ?> · <?= e(date('d M y, h:i A', strtotime($h['created_at']))) ?></small>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div>
    <div class="card" style="margin-bottom:18px;">
      <h2 style="font-size:18px;margin-bottom:14px;">Update status</h2>
      <form method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="update">
        <div class="form-row" style="grid-template-columns:1fr;">
          <label>Status</label>
          <select name="status">
            <?php foreach ($statuses as $s): ?>
            <option value="<?= $s ?>" <?= $appt['status'] === $s ? 'selected' : '' ?>><?= ucwords(str_replace('_',' ',$s)) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-row" style="grid-template-columns:1fr;">
          <label>Status note (optional)</label>
          <input type="text" name="status_note" maxlength="255" placeholder="e.g. Called, will visit Monday">
        </div>
        <div class="form-row" style="grid-template-columns:1fr;">
          <label>Assign to</label>
          <input type="text" name="assigned_to" maxlength="120" value="<?= e($appt['assigned_to'] ?? '') ?>" placeholder="Staff member name">
        </div>
        <div class="form-row" style="grid-template-columns:1fr;">
          <label>Callback date</label>
          <input type="date" name="callback_date" value="<?= e($appt['callback_date'] ?? '') ?>">
        </div>
        <button type="submit" class="btn btn--primary">Save changes</button>
      </form>
    </div>

    <?php if (!empty($appt['email'])): ?>
    <div class="card">
      <h2 style="font-size:18px;margin-bottom:14px;">Reply by email</h2>
      <p style="font-size:13px;color:#7A858A;margin-bottom:12px;">Replies go to <strong><?= e($appt['email']) ?></strong> through your configured SMTP.</p>
      <form method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="reply_email">
        <div class="form-row" style="grid-template-columns:1fr;">
          <textarea name="reply_message" rows="5" placeholder="Type your reply to the patient…" required></textarea>
        </div>
        <button type="submit" class="btn btn--accent">Send reply</button>
      </form>
    </div>
    <?php endif; ?>
  </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
