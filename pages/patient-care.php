<?php
/** Patient Care hub */
require_once __DIR__ . '/../includes/breadcrumbs.php';
$pages = dm_patient_care_pages();
$icons = ['appointment' => 'calendar', 'admission-discharge' => 'bed', 'visitor-information' => 'users', 'patient-rights-responsibilities' => 'shield', 'medical-records' => 'file'];
$descs = [
    'appointment' => 'How to book, what to bring, and what to expect at your first consultation.',
    'admission-discharge' => 'Guidance about admission, your stay and discharge questions.',
    'visitor-information' => 'Guidance for family and friends visiting patients.',
    'patient-rights-responsibilities' => 'What you can expect from us — and what helps us care for you better.',
    'medical-records' => 'How to request copies of your reports, summaries and bills.',
];
?>
<section class="page-hero">
  <div class="container">
    <?php dm_breadcrumbs(['Home' => '', 'Patient Care' => null]); ?>
    <h1>Patient Care &amp; Information</h1>
    <p class="lead" style="max-width:700px;">Guides for appointments, admissions, visiting and medical-record enquiries.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="grid grid--3">
      <?php $i=0; foreach ($pages as $slug => $label): ?>
      <a href="<?= e(dm_url('patient-care/' . $slug)) ?>" class="quick-card reveal<?= $i%3 ? ' reveal-delay-'.($i%3) : '' ?>">
        <span class="quick-card__icon"><?= icon($icons[$slug], 'icon') ?></span>
        <strong><?= e($label) ?></strong>
        <p><?= e($descs[$slug]) ?></p>
        <span class="quick-card__link">Read guide <?= icon('arrow-right', 'icon icon--sm') ?></span>
      </a>
      <?php $i++; endforeach; ?>
      <a href="<?= e(dm_url('insurance')) ?>" class="quick-card reveal">
        <span class="quick-card__icon"><?= icon('shield', 'icon') ?></span>
        <strong>Insurance Assistance</strong>
        <p>Questions about the cashless process, documents and insurer eligibility.</p>
        <span class="quick-card__link">Learn more <?= icon('arrow-right', 'icon icon--sm') ?></span>
      </a>
    </div>
    <div style="margin-top:var(--sp-6);"><?php require __DIR__ . '/../includes/cta-strip.php'; ?></div>
  </div>
</section>
