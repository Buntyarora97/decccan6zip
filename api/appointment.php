<?php
/**
 * API: Appointment request
 * CSRF + honeypot + rate limit + prepared statements + SMTP emails.
 */
declare(strict_types=1);

require_once __DIR__ . '/../includes/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['ok' => false, 'message' => 'Invalid request.'], 405);
}

// CSRF
if (!csrf_verify($_POST['csrf_token'] ?? null)) {
    json_response(['ok' => false, 'message' => '<strong>Session expired.</strong>Please refresh the page and try again.'], 403);
}

// Honeypot — bots fill hidden field
if (!empty($_POST['website'])) {
    json_response(['ok' => true, 'message' => 'Thank you.']); // silent success for bots
}

// Rate limit: 4 requests / 10 min per session
if (rate_limited('appointment', 4, 600)) {
    json_response(['ok' => false, 'message' => '<strong>Too many requests.</strong>Please wait a few minutes or call us at ' . e(DM_PHONE_DISPLAY) . '.'], 429);
}

// ---------- Validate ----------
$errors = [];
$name   = clean($_POST['patient_name'] ?? '', 120);
$mobile = clean($_POST['mobile'] ?? '', 20);
$email  = clean($_POST['email'] ?? '', 190);
$age    = ($_POST['age'] ?? '') !== '' ? (int) $_POST['age'] : null;
$dept   = clean($_POST['department'] ?? '', 80);
$doctor = clean($_POST['doctor'] ?? '', 120);
$date   = clean($_POST['preferred_date'] ?? '', 10);
$time   = clean($_POST['preferred_time'] ?? '', 40);
$type   = ($_POST['patient_type'] ?? 'new') === 'follow_up' ? 'follow_up' : 'new';
$msg    = clean($_POST['message'] ?? '', 1000);
$consent = !empty($_POST['consent']) ? 1 : 0;

if ($name === '' || mb_strlen($name) < 2)        $errors[] = 'patient name';
if (!valid_mobile($mobile))                       $errors[] = 'valid 10-digit mobile number';
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'valid email';
if ($dept === '')                                 $errors[] = 'department';
if ($age !== null && ($age < 0 || $age > 120))    $errors[] = 'valid age';
if ($date !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) $errors[] = 'valid date';
if (!$consent)                                    $errors[] = 'consent';

if ($errors) {
    json_response(['ok' => false, 'message' => '<strong>Please check:</strong> ' . e(implode(', ', $errors)) . '.'], 422);
}

$pdo = db();
if (!$pdo) {
    json_response(['ok' => false, 'message' => '<strong>We could not save your request right now.</strong>Please call us at ' . e(DM_PHONE_DISPLAY) . ' — we apologise for the inconvenience.'], 500);
}

// ---------- Save ----------
$ref = make_ref_no('DMH');
try {
    $stmt = $pdo->prepare(
        'INSERT INTO appointments
         (ref_no, patient_name, mobile, email, age, department, doctor, preferred_date, preferred_time, patient_type, message, utm_source, utm_medium, utm_campaign, ip_address, consent)
         VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'
    );
    $stmt->execute([
        $ref, $name, $mobile, $email ?: null, $age, $dept, $doctor ?: null,
        $date ?: null, $time ?: null, $type, $msg ?: null,
        clean($_POST['utm_source'] ?? '', 120) ?: null,
        clean($_POST['utm_medium'] ?? '', 120) ?: null,
        clean($_POST['utm_campaign'] ?? '', 120) ?: null,
        client_ip(), $consent,
    ]);
} catch (Throwable $e) {
    error_log('Appointment insert failed: ' . $e->getMessage());
    json_response(['ok' => false, 'message' => '<strong>Something went wrong.</strong>Please call us at ' . e(DM_PHONE_DISPLAY) . '.'], 500);
}

// ---------- Emails ----------
$depts = dm_departments();
$deptName = $depts[$dept]['name'] ?? ($dept === 'not-sure' ? 'Not sure — needs guidance' : $dept);

$adminBody = '<table style="border-collapse:collapse;font-size:14px;">'
    . '<tr><td style="padding:6px 14px 6px 0;color:#666;">Reference</td><td><strong>' . e($ref) . '</strong></td></tr>'
    . '<tr><td style="padding:6px 14px 6px 0;color:#666;">Patient</td><td>' . e($name) . ($age ? ' (' . $age . ' yrs)' : '') . '</td></tr>'
    . '<tr><td style="padding:6px 14px 6px 0;color:#666;">Mobile</td><td><a href="tel:' . e($mobile) . '">' . e($mobile) . '</a></td></tr>'
    . ($email ? '<tr><td style="padding:6px 14px 6px 0;color:#666;">Email</td><td>' . e($email) . '</td></tr>' : '')
    . '<tr><td style="padding:6px 14px 6px 0;color:#666;">Department</td><td>' . e($deptName) . '</td></tr>'
    . ($doctor ? '<tr><td style="padding:6px 14px 6px 0;color:#666;">Doctor</td><td>' . e($doctor) . '</td></tr>' : '')
    . ($date ? '<tr><td style="padding:6px 14px 6px 0;color:#666;">Preferred</td><td>' . e($date) . ' ' . e($time) . '</td></tr>' : '')
    . '<tr><td style="padding:6px 14px 6px 0;color:#666;">Type</td><td>' . ($type === 'new' ? 'New patient' : 'Follow-up') . '</td></tr>'
    . ($msg ? '<tr><td style="padding:6px 14px 6px 0;color:#666;vertical-align:top;">Message</td><td>' . nl2br(e($msg)) . '</td></tr>' : '')
    . '</table>';

$notifyTo = dm_setting('hospital_notify_email', defined('HOSPITAL_NOTIFY_EMAIL') ? HOSPITAL_NOTIFY_EMAIL : '');
if ($notifyTo) {
    send_mail($notifyTo, "New appointment request $ref — $name", email_template('New Appointment Request', $adminBody), 'appointment_admin');
}

if ($email) {
    $patientBody = '<p>Dear ' . e($name) . ',</p>'
        . '<p>Thank you for requesting an appointment at Deccan Malti Neuro &amp; Superspeciality Hospital, Sangli. Your request reference is <strong>' . e($ref) . '</strong>.</p>'
        . '<p><strong>Please note:</strong> this is a request, not a confirmed appointment. Our team will call you on ' . e($mobile) . ' to confirm a convenient slot.</p>'
        . '<p>If your need is urgent, please call us directly at ' . e(DM_PHONE_DISPLAY) . '.</p>';
    send_mail($email, "Appointment request received — $ref", email_template('We received your request', $patientBody), 'appointment_patient');
}

$waText = rawurlencode("Hello Deccan Malti Hospital, I just submitted an appointment request ($ref) for $deptName. Please confirm my slot.");
json_response([
    'ok' => true,
    'message' => '<strong>Request received — reference ' . e($ref) . '.</strong>Our team will call ' . e($mobile) . ' to confirm your slot. This is not a confirmed appointment until we speak with you.'
        . '<br><a href="https://wa.me/918830006879?text=' . $waText . '" target="_blank" rel="noopener" style="color:inherit;font-weight:700;text-decoration:underline;">Continue on WhatsApp →</a>',
    'ref' => $ref,
]);
