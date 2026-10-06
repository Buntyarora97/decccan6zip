<?php
/** Admin layout header. $adminTitle set karein har page par. */
declare(strict_types=1);
$adminTitle = $adminTitle ?? 'Admin';
$adminActive = $adminActive ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex, nofollow">
<title><?= e($adminTitle) ?> — Deccan Malti Admin</title>
<link rel="icon" type="image/webp" href="<?= e(dm_url('assets/img/favicon-brand.webp')) ?>">
<link rel="stylesheet" href="<?= e(dm_url('admin/assets/admin.css')) ?>?v=1.0.4">
</head>
<body>
<div class="admin-shell">
  <aside class="admin-side">
    <a class="admin-brand" href="<?= e(admin_url('dashboard.php')) ?>">
      <img src="<?= e(dm_url('assets/img/logo-mark.webp')) ?>" alt="" width="38" height="38">
      <span>Deccan Malti<br><small>Admin Panel</small></span>
    </a>
    <nav class="admin-nav">
      <a href="<?= e(admin_url('dashboard.php')) ?>" class="<?= $adminActive === 'dashboard' ? 'is-active' : '' ?>">Dashboard</a>
      <a href="<?= e(admin_url('appointments.php')) ?>" class="<?= $adminActive === 'appointments' ? 'is-active' : '' ?>">Appointments</a>
      <a href="<?= e(admin_url('contacts.php')) ?>" class="<?= $adminActive === 'contacts' ? 'is-active' : '' ?>">Contact Enquiries</a>
      <a href="<?= e(admin_url('insurance.php')) ?>" class="<?= $adminActive === 'insurance' ? 'is-active' : '' ?>">Insurance Enquiries</a>
      <a href="<?= e(admin_url('newsletter.php')) ?>" class="<?= $adminActive === 'newsletter' ? 'is-active' : '' ?>">Newsletter</a>
      <a href="<?= e(admin_url('audit.php')) ?>" class="<?= $adminActive === 'audit' ? 'is-active' : '' ?>">Audit Log</a>
      <a href="<?= e(admin_url('settings.php')) ?>" class="<?= $adminActive === 'settings' ? 'is-active' : '' ?>">Settings</a>
    </nav>
    <div class="admin-side__foot">
      <span><?= e($_SESSION['admin_name'] ?? '') ?></span>
      <a href="<?= e(admin_url('logout.php')) ?>">Log out</a>
    </div>
  </aside>
  <main class="admin-main">
    <div class="admin-topbar">
      <h1><?= e($adminTitle) ?></h1>
      <a href="<?= e(dm_url()) ?>" target="_blank" rel="noopener">View website ↗</a>
    </div>
    <div class="admin-content">
