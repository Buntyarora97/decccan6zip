<?php
/**
 * Patient-friendly overview for the site's existing department routes.
 * Vars: $dept (array), $slug (string)
 */
require_once __DIR__ . '/../includes/breadcrumbs.php';
$service = dm_service_for_department($slug);
$serviceName = $service['name'] ?? $dept['name'];
$serviceSummary = $service['summary'] ?? $dept['summary'];
$relatedServices = [];
foreach (dm_services() as $category) {
    foreach ($category['groups'] as $items) {
        foreach ($items as $item) {
            if (($item['department'] ?? null) !== $slug && count($relatedServices) < 5) {
                $relatedServices[] = $item;
            }
        }
    }
}
?>
<section class="page-hero">
  <div class="container">
    <?php dm_breadcrumbs(['Home' => '', 'Services' => 'departments', $serviceName => null]); ?>
    <h1><?= e($serviceName) ?> in Sangli</h1>
    <p class="lead" style="max-width:760px;"><?= e($serviceSummary) ?></p>
    <div class="page-hero__ctas">
      <a href="<?= e(dm_url('appointment')) ?>?department=<?= e($slug) ?>" class="btn btn--accent"><?= icon('calendar', 'icon icon--sm') ?> Request a Consultation</a>
      <a href="tel:<?= e(DM_PHONE) ?>" class="btn btn--ghost-light"><?= icon('phone', 'icon icon--sm') ?> <?= e(DM_PHONE_DISPLAY) ?></a>
    </div>
  </div>
</section>

<section class="section">
  <div class="container service-detail-layout">
    <div class="service-detail-icon" aria-hidden="true"><?= icon($service['icon'] ?? $dept['icon'], 'icon') ?></div>
    <div class="service-detail-copy">
      <span class="eyebrow">Service Overview</span>
      <h2>Discuss your concern with the clinical team</h2>
      <p><?= e($serviceSummary) ?></p>
      <p>A clinician can review your concern, medical history and available reports, then explain whether a specialist consultation, investigation or another next step may be appropriate for you.</p>
      <p class="medical-note"><?= icon('info', 'icon icon--sm') ?><span>This page provides general information and does not diagnose a condition or replace advice from a qualified clinician.</span></p>
    </div>
  </div>
</section>

<section class="section section--soft">
  <div class="container">
    <div class="section__head reveal">
      <span class="eyebrow">Planning a Visit</span>
      <h2>What to bring to your consultation</h2>
      <p class="lead">Bring relevant medical records so the clinician can consider them with your history and examination.</p>
    </div>
    <div class="service-visit-list">
      <div><?= icon('document-check', 'icon') ?><span>Previous reports, scans and prescriptions related to your concern.</span></div>
      <div><?= icon('pill', 'icon') ?><span>A current list of medicines, if applicable.</span></div>
      <div><?= icon('shield', 'icon') ?><span>Your insurance card and policy information, if you want to ask about insurance assistance.</span></div>
    </div>
    <p class="section__footer-link">
      <a href="<?= e(dm_url('appointment')) ?>?department=<?= e($slug) ?>" class="btn btn--primary"><?= icon('calendar', 'icon icon--sm') ?> Request an Appointment</a>
      <a href="<?= e(dm_url('patient-care/appointment')) ?>" class="btn btn--outline">Appointment guide</a>
    </p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section__head">
      <span class="eyebrow">Related Services</span>
      <h2>Explore other services</h2>
    </div>
    <div class="specialty-grid specialty-grid--related">
      <?php foreach ($relatedServices as $item): ?>
      <article class="specialty-card">
        <span class="bento__icon"><?= icon($item['icon'], 'icon') ?></span>
        <h3><?= e($item['name']) ?></h3>
        <p><?= e($item['summary']) ?></p>
        <a href="<?= e(dm_service_url($item)) ?>">Service overview <?= icon('arrow-right', 'icon icon--sm') ?></a>
      </article>
      <?php endforeach; ?>
    </div>
    <div style="margin-top:var(--sp-6);"><?php require __DIR__ . '/../includes/cta-strip.php'; ?></div>
  </div>
</section>
