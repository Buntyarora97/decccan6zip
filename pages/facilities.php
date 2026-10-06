<?php
/** Facilities, accommodation, infrastructure and enquiry guidance. */
require_once __DIR__ . '/../includes/breadcrumbs.php';
$facilityData = dm_facilities();
$galleryPreview = [
    ['hospital-exterior-approach.webp', 'Hospital exterior from the entrance approach', 'Hospital exterior'],
    ['emergency-entrance-signage.webp', 'Emergency entrance signage at Deccan Malti Hospital', 'Emergency entrance'],
    ['diagnostic-work-area.webp', 'Diagnostic work area; specific equipment is not identified', 'Diagnostic work area'],
    ['hospital-corridor.webp', 'Interior corridor at Deccan Malti Hospital', 'Hospital corridor'],
];
?>
<section class="page-hero">
  <div class="container">
    <?php dm_breadcrumbs(['Home' => '', 'Facilities' => null]); ?>
    <h1>Facilities &amp; Accommodation</h1>
    <p class="lead" style="max-width:760px;">Explore emergency and critical-care categories, inpatient room types, diagnostic infrastructure and patient support at Deccan Malti Hospital.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="facility-intro">
      <div class="facility-intro__copy reveal">
        <span class="eyebrow">The Hospital</span>
        <h2>Care and support in Vishrambag, Sangli</h2>
        <p>Deccan Malti Hospital is on Sangli–Miraj Road in Vishrambag, opposite Ambassador Hotel and beside Sushil Hospital. The hospital team can answer questions about current facilities and room availability.</p>
        <div class="facility-intro__actions">
          <a href="<?= e(dm_url('contact')) ?>" class="btn btn--primary">Ask a facility question <?= icon('arrow-right', 'icon icon--sm') ?></a>
          <a href="<?= e(dm_brochure_url()) ?>" download="Deccan-Malti-Hospital-Guide.pdf" class="btn btn--outline"><?= icon('download', 'icon icon--sm') ?> Download Hospital Guide</a>
        </div>
      </div>
      <figure class="facility-intro__photo reveal reveal-delay-1">
        <img src="<?= e(dm_url('assets/img/hospital-shoot/hospital-exterior-approach.webp')) ?>" alt="Daytime exterior and entrance approach of Deccan Malti Hospital" width="1800" height="1200" fetchpriority="high" decoding="async">
        <figcaption>Deccan Malti Hospital, Vishrambag</figcaption>
      </figure>
    </div>
  </div>
</section>

<section class="section section--soft">
  <div class="container">
    <div class="section__head reveal">
      <span class="eyebrow">Emergency &amp; Critical Care</span>
      <h2>Emergency and critical-care categories</h2>
      <p class="lead">The treating team advises on the appropriate level of care for each patient.</p>
    </div>
    <div class="facility-feature-grid">
      <?php foreach ($facilityData['critical_care'] as $facility): ?>
      <article class="facility-card reveal" id="<?= e($facility['id']) ?>">
        <span class="bento__icon"><?= icon($facility['icon'], 'icon') ?></span>
        <h3><?= e($facility['name']) ?></h3>
        <p><?= e($facility['summary']) ?></p>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section__head reveal">
      <span class="eyebrow">Rooms &amp; Accommodation</span>
      <h2>Room categories</h2>
      <p class="lead">Room category, suitability and availability should be confirmed with the hospital team. An enquiry does not reserve a room.</p>
    </div>
    <div class="room-grid">
      <?php foreach ($facilityData['rooms'] as $room): ?>
      <article class="room-card reveal" id="<?= e($room['id']) ?>">
        <span class="bento__icon"><?= icon($room['icon'], 'icon') ?></span>
        <h3><?= e($room['name']) ?></h3>
        <p><?= e($room['summary']) ?></p>
      </article>
      <?php endforeach; ?>
    </div>
    <p class="section__footer-link"><a href="<?= e(dm_url('contact')) ?>" class="btn btn--outline">Enquire about room categories <?= icon('arrow-right', 'icon icon--sm') ?></a></p>
  </div>
</section>

<section class="section section--tint" id="infrastructure">
  <div class="container">
    <div class="section__head reveal">
      <span class="eyebrow">Advanced Infrastructure &amp; Patient Support</span>
      <h2>Facilities and support services</h2>
      <p class="lead">Descriptions are limited to the hospital facilities listed in the supplied brief. Technical specifications and financial eligibility are not implied.</p>
    </div>
    <div class="infrastructure-grid">
      <?php foreach ($facilityData['infrastructure'] as $item): ?>
      <article class="reveal" id="<?= e($item['id']) ?>">
        <span class="bento__icon"><?= icon($item['icon'], 'icon') ?></span>
        <h3><?= e($item['name']) ?></h3>
        <p><?= e($item['summary']) ?></p>
        <?php if (in_array($item['id'], ['cashless-insurance-assistance', 'cmrf-guidance'], true)): ?>
        <a href="<?= e(dm_url('insurance' . ($item['id'] === 'cmrf-guidance' ? '#cmrf-help' : '#empanelment-help'))) ?>" class="facility-card__link">Ask about eligibility <?= icon('arrow-right', 'icon icon--sm') ?></a>
        <?php endif; ?>
      </article>
      <?php endforeach; ?>
    </div>
    <p class="facility-disclaimer">Availability and suitability of facilities are confirmed by the hospital and treating team. Insurance and CMRF eligibility and approvals depend on the relevant insurer or programme.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section__head reveal">
      <span class="eyebrow">Hospital Gallery</span>
      <h2>Spaces and services</h2>
      <p class="lead">Photographs are shown in full with neutral captions where a room or equipment type is not visually certain.</p>
    </div>
    <div class="home-photo-grid">
      <?php foreach ($galleryPreview as [$filename, $alt, $caption]): ?>
      <figure class="reveal">
        <img src="<?= e(dm_url('assets/img/hospital-shoot/' . $filename)) ?>" alt="<?= e($alt) ?>" width="1800" height="1200" loading="lazy" decoding="async">
        <figcaption><?= e($caption) ?></figcaption>
      </figure>
      <?php endforeach; ?>
    </div>
    <p class="section__footer-link">
      <a href="<?= e(dm_url('gallery')) ?>" class="btn btn--outline">View the full photo gallery <?= icon('arrow-right', 'icon icon--sm') ?></a>
      <a href="tel:<?= e(DM_PHONE) ?>" class="btn btn--primary"><?= icon('phone', 'icon icon--sm') ?> Call <?= e(DM_PHONE_DISPLAY) ?></a>
    </p>
    <div style="margin-top:var(--sp-6);"><?php require __DIR__ . '/../includes/cta-strip.php'; ?></div>
  </div>
</section>
