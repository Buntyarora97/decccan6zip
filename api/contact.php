<?php
/** API: Contact enquiry */
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
if (rate_limited('contact', 5, 600)) {
    json_response(['ok' => false, 'message' => '<strong>Too many requests.</strong>Please wait a few minutes or call ' . e(DM_PHONE_DISPLAY) . '.'], 429);
}

$name   = clean($_POST['name'] ?? '', 120);
$email  = clean($_POST['email'] ?? '', 190);
$phone  = clean($_POST['phone'] ?? '', 20);
$dept   = clean($_POST['department'] ?? '', 80);
$subject = clean($_POST['subject'] ?? '', 160);
$msg    = clean($_POST['message'] ?? '', 1500);
$consent = !empty($_POST['consent']) ? 1 : 0;

$errors = [];
if ($name === '' || mb_strlen($name) < 2) $errors[] = 'name';
if ($msg === '') $errors[] = 'message';
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'valid email';
if ($email === '' && $phone === '') $errors[] = 'phone or email';
if (!$consent) $errors[] = 'consent';

if ($errors) {
    json_response(['ok' => false, 'message' => '<strong>Please check:</strong> ' . e(implode(', ', $errors)) . '.'], 422);
}

$pdo = db();
if (!$pdo) {
    json_response(['ok' => false, 'message' => '<strong>Could not send right now.</strong>Please call us at ' . e(DM_PHONE_DISPLAY) . '.'], 500);
}

try {
    $stmt = $pdo->prepare('INSERT INTO contact_enquiries (name, email, phone, department, subject, message, consent, ip_address) VALUES (?,?,?,?,?,?,?,?)');
    $stmt->execute([$name, $email ?: null, $phone ?: null, $dept ?: null, $subject ?: null, $msg, $consent, client_ip()]);
} catch (Throwable $e) {
    error_log('Contact insert failed: ' . $e->getMessage());
    json_response(['ok' => false, 'message' => '<strong>Something went wrong.</strong>Please call ' . e(DM_PHONE_DISPLAY) . '.'], 500);
}

$notifyTo = dm_setting('hospital_notify_email', defined('HOSPITAL_NOTIFY_EMAIL') ? HOSPITAL_NOTIFY_EMAIL : '');
if ($notifyTo) {
    $body = '<p><strong>From:</strong> ' . e($name) . '<br><strong>Phone:</strong> ' . e($phone) . '<br><strong>Email:</strong> ' . e($email)
        . '<br><strong>Department:</strong> ' . e($dept ?: 'General') . '<br><strong>Subject:</strong> ' . e($subject) . '</p><p>' . nl2br(e($msg)) . '</p>';
    send_mail($notifyTo, 'Website enquiry — ' . ($subject ?: $name), email_template('New Contact Enquiry', $body), 'contact_admin');
}

json_response(['ok' => true, 'message' => '<strong>Message sent.</strong>Thank you, ' . e($name) . ' — our team will get back to you shortly.']);
