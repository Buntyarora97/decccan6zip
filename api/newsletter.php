<?php
/** API: Newsletter subscribe */
declare(strict_types=1);

require_once __DIR__ . '/../includes/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['ok' => false, 'message' => 'Invalid request.'], 405);
}
if (!csrf_verify($_POST['csrf_token'] ?? null)) {
    json_response(['ok' => false, 'message' => 'Session expired. Please refresh the page.'], 403);
}
if (rate_limited('newsletter', 3, 600)) {
    json_response(['ok' => false, 'message' => 'Too many attempts. Please wait a few minutes.'], 429);
}

$email = clean($_POST['email'] ?? '', 190);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    json_response(['ok' => false, 'message' => 'Please enter a valid email address.'], 422);
}

$pdo = db();
if (!$pdo) {
    json_response(['ok' => false, 'message' => 'Could not subscribe right now. Please try later.'], 500);
}

try {
    $stmt = $pdo->prepare('INSERT INTO newsletter_subscribers (email, consent, ip_address) VALUES (?,?,?) ON DUPLICATE KEY UPDATE consent = VALUES(consent)');
    $stmt->execute([$email, 1, client_ip()]);
    json_response(['ok' => true, 'message' => 'Subscribed! You will hear from us about once a month.']);
} catch (Throwable $e) {
    error_log('Newsletter insert failed: ' . $e->getMessage());
    json_response(['ok' => false, 'message' => 'Could not subscribe right now. Please try later.'], 500);
}
