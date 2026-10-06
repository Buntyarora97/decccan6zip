<?php
/**
 * Reusable conversion strip — har inner page ke end mein.
 */
?>
<div class="cta-strip reveal">
  <div>
    <h3>Ready to talk to a specialist?</h3>
    <p>Request an appointment and our team will call you to confirm a convenient slot.</p>
  </div>
  <div class="cta-strip__actions">
    <a href="<?= e(dm_url('appointment')) ?>" class="btn btn--accent"><?= icon('calendar', 'icon icon--sm') ?> Book Appointment</a>
    <a href="tel:<?= e(DM_PHONE) ?>" class="btn btn--white"><?= icon('phone', 'icon icon--sm') ?> <?= e(DM_PHONE_DISPLAY) ?></a>
    <a href="<?= e(DM_WHATSAPP) ?>" target="_blank" rel="noopener" class="btn btn--ghost-light"><?= icon('whatsapp', 'icon icon--sm') ?> WhatsApp</a>
  </div>
</div>
