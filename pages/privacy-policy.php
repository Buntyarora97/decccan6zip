<?php
require_once __DIR__ . '/../includes/breadcrumbs.php';
?>
<section class="page-hero">
  <div class="container">
    <?php dm_breadcrumbs(['Home' => '', 'Privacy Policy' => null]); ?>
    <h1>Privacy Policy</h1>
    <p class="lead">How we collect, use and protect your information. Last updated: September 2026.</p>
  </div>
</section>
<section class="section">
  <div class="container prose" style="max-width:820px;">
    <h2>What we collect</h2>
    <p>When you use our appointment, contact, insurance or newsletter forms, we collect the details you provide — typically your name, phone number, email address, and the content of your message or appointment request. We also record your consent and technical details such as the time of submission. We do not ask for medical reports or sensitive health documents through website forms, and we request that you do not send them through these forms.</p>
    <h2>How we use it</h2>
    <p>Your details are used for one purpose: to respond to you. Appointment requests are used to call you back and arrange your consultation. Contact enquiries are used to answer your question. Newsletter emails are used to send you the updates you subscribed to. We do not sell, rent or share your personal information with third parties for marketing.</p>
    <h2>How it is stored and protected</h2>
    <p>Form submissions are stored in a secured database accessible only to authorised hospital staff, protected by passwords and access controls. Email communication is sent through authenticated, encrypted SMTP channels.</p>
    <h2>Cookies</h2>
    <p>This website uses only essential technical cookies (such as session cookies required for forms to work securely). We do not use advertising trackers. <!-- [VERIFY] if analytics is added later, disclose here --></p>
    <h2>Your choices</h2>
    <p>You may ask us at any time to correct or delete your submitted information, or to unsubscribe from newsletters, by calling <?= e(DM_PHONE_DISPLAY) ?> or writing to us through the contact page.</p>
    <h2>Changes</h2>
    <p>If this policy changes, the updated version will be posted on this page with a revised date.</p>
    <h2>Contact</h2>
    <p>Deccan Malti Neuro &amp; Superspeciality Hospital, <?= e(DM_ADDRESS) ?> · <?= e(DM_PHONE_DISPLAY) ?></p>
  </div>
</section>
