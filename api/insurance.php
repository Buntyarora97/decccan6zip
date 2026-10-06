<?php
/** API: Insurance eligibility enquiry */
declare(strict_types=1);

require_once __DIR__ . '/../includes/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['ok' => false, 'message' => 'Invalid request.'], 405);
}
if (!csrf_verify($_POST['csrf_token'] ?? null)) {
    json_response(['ok' => false, 'message' => '<strong>Session expired.</strong>Please refresh and try again.'], 403);
}
if (!empty($_POST['website'])) {
    json_response(['ok' => true, 'message' => 'Thank you.']);
}
if (rate_limited('insurance', 4, 600)) {
    json_response(['ok' => false, 'message' => '<strong>Too many requests.</strong>Please call ' . e(DM_PHONE_DISPLAY) . ' instead.'], 429);
}

$name   = clean($_POST['name'] ?? '', 120);
$mobile = clean($_POST['mobile'] ?? '', 20);
$email  = clean($_POST['email'] ?? '', 190);
$insurer = clean($_POST['insurer'] ?? '', 120);
$type   = in_array($_POST['admission_type'] ?? '', ['planned', 'emergency', 'not_sure'], true) ? $_POST['admission_type'] : 'not_sure';
$msg    = clean($_POST['message'] ?? '', 800);
$consent = !empty($_POST['consent']) ? 1 : 0;

$errors = [];
if ($name === '' || mb_strlen($name) < 2) $errors[] = 'name';
if (!valid_mobile($mobile)) $errors[] = 'valid mobile number';
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'valid email';
if (!$consent) $errors[] = 'consent';

if ($errors) {
    json_response(['ok' => false, 'message' => '<strong>Please check:</strong> ' . e(implode(', ', $errors)) . '.'], 422);
}

$pdo = db();
if (!$pdo) {
    json_response(['ok' => false, 'message' => '<strong>Could not submit right now.</strong>Please call ' . e(DM_PHONE_DISPLAY) . '.'], 500);
}

try {
    $stmt = $pdo->prepare('INSERT INTO insurance_enquiries (name, mobile, email, insurer, admission_type, message, consent, ip_address) VALUES (?,?,?,?,?,?,?,?)');
    $stmt->execute([$name, $mobile, $email ?: null, $insurer ?: null, $type, $msg ?: null, $consent, client_ip()]);
} catch (Throwable $e) {
    error_log('Insurance insert failed: ' . $e->getMessage());
    json_response(['ok' => false, 'message' => '<strong>Something went wrong.</strong>Please call ' . e(DM_PHONE_DISPLAY) . '.'], 500);
}

$notifyTo = dm_setting('hospital_notify_email', defined('HOSPITAL_NOTIFY_EMAIL') ? HOSPITAL_NOTIFY_EMAIL : '');
if ($notifyTo) {
    $body = '<p><strong>Name:</strong> ' . e($name) . '<br><strong>Mobile:</strong> ' . e($mobile)
        . '<br><strong>Insurer/TPA:</strong> ' . e($insurer) . '<br><strong>Admission type:</strong> ' . e($type) . '</p><p>' . nl2br(e($msg)) . '</p>';
    send_mail($notifyTo, 'Insurance eligibility enquiry — ' . $name, email_template('Insurance Eligibility Enquiry', $body), 'insurance_admin');
}

json_response(['ok' => true, 'message' => '<strong>Enquiry received.</strong>Our insurance desk will call ' . e($mobile) . ' to discuss your policy coverage. Please keep your policy document handy.']);
