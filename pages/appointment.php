<?php
/** Appointment page */
require_once __DIR__ . '/../includes/breadcrumbs.php';
?>
<section class="page-hero">
  <div class="container">
    <?php dm_breadcrumbs(['Home' => '', 'Book an Appointment' => null]); ?>
    <h1>Book an Appointment</h1>
    <p class="lead" style="max-width:680px;">Submit an appointment request below. Contact the hospital to confirm a suitable time and any visit instructions.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="grid" style="grid-template-columns:1.5fr 1fr;align-items:start;">
      <div class="reveal">
        <?php require __DIR__ . '/../includes/appointment-form.php'; ?>
      </div>
      <aside style="display:flex;flex-direction:column;gap:18px;">
        <div class="card reveal reveal-delay-1">
          <h3 style="margin-bottom:14px;"><?= icon('phone', 'icon icon--sm') ?> Prefer to call?</h3>
          <p style="color:var(--text-soft);font-size:15px;margin-bottom:14px;">Call the hospital to ask about appointment availability:</p>
          <a href="tel:<?= e(DM_PHONE) ?>" class="btn btn--primary btn--block" style="margin-bottom:10px;"><?= e(DM_PHONE_DISPLAY) ?></a>
          <a href="tel:<?= e(DM_LANDLINE) ?>" class="btn btn--outline btn--block"><?= e(DM_LANDLINE_DISPLAY) ?></a>
        </div>
        <div class="card reveal reveal-delay-2">
          <h3 style="margin-bottom:14px;"><?= icon('whatsapp', 'icon icon--sm') ?> WhatsApp us</h3>
          <p style="color:var(--text-soft);font-size:15px;margin-bottom:14px;">Send a message to ask about appointment availability.</p>
          <a href="<?= e(DM_WHATSAPP) ?>" target="_blank" rel="noopener" class="btn btn--outline btn--block">Chat on WhatsApp</a>
        </div>
        <div class="emergency-note reveal reveal-delay-3">
          <?= icon('alert', 'icon') ?>
          <span>For medical emergencies, do not wait for an appointment — go to the nearest emergency facility or call local emergency services.</span>
        </div>
      </aside>
    </div>
  </div>
</section>
