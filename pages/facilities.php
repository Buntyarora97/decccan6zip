<?php
/** Facilities, accommodation, infrastructure and enquiry guidance. */
require_once __DIR__ . '/../includes/breadcrumbs.php';
$facilityData = dm_facilities();
$facilityPhotos = [
    'casualty-emergency' => ['src' => 'assets/img/hospital-shoot/emergency-entrance-signage.webp', 'alt' => 'Emergency entrance signage at Deccan Malti Hospital'],
    'icu' => ['src' => 'assets/img/hospital-shoot/zoned-care-area.webp', 'alt' => 'Hospital care-area bed; this photo does not identify a specific unit'],
    'hdu' => ['src' => 'assets/img/real/p6a5774.webp', 'alt' => 'In-patient ward at Deccan Malti Hospital; specific unit not identified'],
    'male-general-ward' => ['src' => 'assets/img/real/p6a5774.webp', 'alt' => 'In-patient ward at Deccan Malti Hospital; gender-specific category not identified'],
    'female-general-ward' => ['src' => 'assets/img/real/p6a6088.webp', 'alt' => 'Patient-care room with beds; gender-specific category not identified'],
    'ac-single-deluxe' => ['src' => 'assets/img/real/hospital-patient-room.webp', 'alt' => 'Patient-care room at Deccan Malti Hospital; air-conditioning is not shown'],
    'non-ac-single-deluxe' => ['src' => 'assets/img/real/p6a5831.webp', 'alt' => 'Patient room at Deccan Malti Hospital; air-conditioning is not shown'],
    'suite-room' => ['src' => 'assets/img/hospital-shoot/hospital-interior-room-detail.webp', 'alt' => 'Hospital interior; suite designation is not identified in this photo'],
    'modular-operation-theatre' => ['src' => 'assets/img/real/p6a6030.webp', 'alt' => 'Operating theatre at Deccan Malti Hospital'],
    'pentero-surgical-microscope' => ['src' => 'assets/img/hospital-shoot/diagnostic-work-area-angle.webp', 'alt' => 'Hospital work area; microscope model is not identified in this photo'],
    'cusa-technology' => ['src' => 'assets/img/hospital-shoot/diagnostic-work-area.webp', 'alt' => 'Hospital work area; CUSA equipment is not identified in this photo'],
    'in-house-ct-scan' => ['src' => 'assets/img/hospital-shoot/diagnostic-imaging-room.webp', 'alt' => 'Diagnostic imaging room at Deccan Malti Hospital; equipment model not identified'],
    'pathology-lab' => ['src' => 'assets/img/hospital-shoot/diagnostic-work-area-angle.webp', 'alt' => 'Diagnostic work area; specific laboratory equipment is not identified'],
    '24-7-pharmacy' => ['src' => 'assets/img/hospital-shoot/hospital-side-view.webp', 'alt' => 'Exterior view of Deccan Malti Hospital; pharmacy interior is not pictured'],
    'physiotherapy-rehabilitation' => ['src' => 'assets/img/hospital-shoot/hospital-interior-room-angle.webp', 'alt' => 'Hospital interior; rehabilitation equipment is not pictured'],
    'cashless-insurance-assistance' => ['src' => 'assets/img/hospital-shoot/hospital-emblem-display.webp', 'alt' => 'Deccan Malti Hospital emblem; insurance process is not pictured'],
    'cmrf-guidance' => ['src' => 'assets/img/hospital-shoot/hospital-corridor.webp', 'alt' => 'Hospital corridor at Deccan Malti Hospital; CMRF process is not pictured'],
];
$supportIds = ['24-7-pharmacy', 'physiotherapy-rehabilitation', 'cashless-insurance-assistance', 'cmrf-guidance'];
$infrastructureFacilities = array_values(array_filter(
    $facilityData['infrastructure'],
    static fn(array $item): bool => !in_array($item['id'], $supportIds, true)
));
$supportFacilities = array_values(array_filter(
    $facilityData['infrastructure'],
    static fn(array $item): bool => in_array($item['id'], $supportIds, true)
));
$facilityGallery = [
    ['src' => 'assets/img/hospital-shoot/hospital-exterior-approach.webp', 'alt' => 'Deccan Malti Hospital exterior and entrance approach', 'label' => 'The hospital'],
    ['src' => 'assets/img/hospital-shoot/emergency-entrance-signage.webp', 'alt' => 'Emergency entrance signage at Deccan Malti Hospital', 'label' => 'Emergency access'],
    ['src' => 'assets/img/real/p6a6030.webp', 'alt' => 'Operating theatre at Deccan Malti Hospital', 'label' => 'Operating theatre'],
    ['src' => 'assets/img/hospital-shoot/diagnostic-imaging-room.webp', 'alt' => 'Diagnostic imaging room at Deccan Malti Hospital', 'label' => 'Diagnostic imaging'],
    ['src' => 'assets/img/real/p6a5774.webp', 'alt' => 'In-patient ward at Deccan Malti Hospital', 'label' => 'In-patient care'],
    ['src' => 'assets/img/real/p6a6088.webp', 'alt' => 'Patient-care room with beds at Deccan Malti Hospital', 'label' => 'Patient-care room'],
];
?>
<div class="facilities-page">
  <section class="facilities-hero">
    <div class="container">
      <?php dm_breadcrumbs(['Home' => '', 'Facilities' => null]); ?>
      <div class="facilities-hero__grid">
        <div class="facilities-hero__copy">
          <span class="facilities-eyebrow"><span></span> Deccan Malti Hospital · Vishrambag, Sangli</span>
          <h1>Care, comfort and support — all in one place</h1>
          <p>Explore the hospital’s emergency and critical-care categories, room options, infrastructure and patient support. The hospital team can confirm exact room details and current availability.</p>
          <div class="facilities-hero__actions">
            <a class="facilities-button facilities-button--light" href="#critical-care">Explore facilities <span aria-hidden="true">↓</span></a>
            <a class="facilities-button facilities-button--glass" href="tel:<?= e(DM_PHONE) ?>"><?= icon('phone', 'icon icon--sm') ?> Call <?= e(DM_PHONE_DISPLAY) ?></a>
          </div>
          <div class="facilities-hero__tags" aria-label="Facility highlights">
            <span>Emergency &amp; critical care</span>
            <span>Inpatient room categories</span>
            <span>24/7 pharmacy</span>
          </div>
        </div>
        <div class="facilities-hero__visual">
          <figure class="facilities-hero__main-photo">
            <img src="<?= e(dm_url('assets/img/hospital-shoot/hospital-exterior-approach.webp')) ?>" alt="Deccan Malti Hospital exterior and entrance approach" fetchpriority="high" decoding="async">
            <figcaption><span class="facilities-photo-dot"></span> Deccan Malti Hospital, Sangli</figcaption>
          </figure>
          <figure class="facilities-hero__inset-photo">
            <img src="<?= e(dm_url('assets/img/real/p6a6088.webp')) ?>" alt="Patient-care room with beds at Deccan Malti Hospital" decoding="async">
          </figure>
          <div class="facilities-hero__location">
            <span class="facilities-hero__location-icon"><?= icon('map-pin', 'icon') ?></span>
            <span><strong>Vishrambag</strong><small>Sangli–Miraj Road</small></span>
          </div>
          <span class="facilities-hero__orbit facilities-hero__orbit--one"></span>
          <span class="facilities-hero__orbit facilities-hero__orbit--two"></span>
        </div>
      </div>
    </div>
  </section>

  <div class="facilities-page__jump">
    <div class="container">
      <nav class="facilities-jump-nav" aria-label="On this page">
        <span>Explore:</span>
        <a href="#critical-care">Emergency &amp; critical care</a>
        <a href="#rooms">Room categories</a>
        <a href="#infrastructure">Infrastructure</a>
        <a href="#support">Patient support</a>
        <a href="#visit">Location</a>
      </nav>
    </div>
  </div>

  <section class="facilities-highlights" aria-label="Facility overview">
    <div class="container facilities-highlight-grid">
      <div class="facilities-highlight">
        <span class="facilities-highlight__icon"><?= icon('alert', 'icon') ?></span>
        <span><strong>Emergency care</strong><small>Urgent medical concerns</small></span>
      </div>
      <div class="facilities-highlight">
        <span class="facilities-highlight__icon"><?= icon('pulse', 'icon') ?></span>
        <span><strong>Critical-care categories</strong><small>ICU and HDU</small></span>
      </div>
      <div class="facilities-highlight">
        <span class="facilities-highlight__icon"><?= icon('scan', 'icon') ?></span>
        <span><strong>Diagnostics &amp; lab</strong><small>CT and pathology services</small></span>
      </div>
      <div class="facilities-highlight">
        <span class="facilities-highlight__icon"><?= icon('bed', 'icon') ?></span>
        <span><strong>Room options</strong><small>Ask about current availability</small></span>
      </div>
    </div>
  </section>

  <section class="facilities-section facilities-section--soft" id="critical-care">
    <div class="container">
      <div class="facilities-section__heading">
        <div>
          <span class="facilities-eyebrow facilities-eyebrow--blue">01 · Emergency &amp; critical care</span>
          <h2>Care when it matters most</h2>
          <p>These care categories are part of the hospital’s listed facilities. The treating team decides the appropriate level of care for each patient.</p>
        </div>
        <a class="facilities-text-link" href="<?= e(dm_url('contact')) ?>">Ask the hospital team <span aria-hidden="true">→</span></a>
      </div>
      <div class="facilities-card-grid facilities-card-grid--three">
        <?php foreach ($facilityData['critical_care'] as $facility): $photo = $facilityPhotos[$facility['id']]; ?>
        <article class="facilities-card" id="<?= e($facility['id']) ?>">
          <figure class="facilities-card__media">
            <img src="<?= e(dm_url($photo['src'])) ?>" alt="<?= e($photo['alt']) ?>" loading="lazy" decoding="async">
            <span class="facilities-card__badge">Care at Deccan Malti</span>
          </figure>
          <div class="facilities-card__body">
            <span class="facilities-card__icon"><?= icon($facility['icon'], 'icon') ?></span>
            <h3><?= e($facility['name']) ?></h3>
            <p><?= e($facility['summary']) ?></p>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
      <p class="facilities-photo-note">Photographs show real hospital spaces. They do not identify an exact unit or equipment model unless that detail is named in the caption.</p>
    </div>
  </section>

  <section class="facilities-section" id="rooms">
    <div class="container">
      <div class="facilities-section__heading">
        <div>
          <span class="facilities-eyebrow facilities-eyebrow--blue">02 · Rooms &amp; accommodation</span>
          <h2>Room categories for inpatient stays</h2>
          <p>Review the categories listed by the hospital. Confirm the exact room type, suitability and availability directly with the team.</p>
        </div>
        <a class="facilities-text-link" href="<?= e(dm_url('contact')) ?>">Enquire about rooms <span aria-hidden="true">→</span></a>
      </div>
      <div class="facilities-card-grid facilities-card-grid--rooms">
        <?php foreach ($facilityData['rooms'] as $room): $photo = $facilityPhotos[$room['id']]; ?>
        <article class="facilities-card facilities-card--room" id="<?= e($room['id']) ?>">
          <figure class="facilities-card__media">
            <img src="<?= e(dm_url($photo['src'])) ?>" alt="<?= e($photo['alt']) ?>" loading="lazy" decoding="async">
            <span class="facilities-card__badge">Room category</span>
          </figure>
          <div class="facilities-card__body">
            <span class="facilities-card__icon"><?= icon($room['icon'], 'icon') ?></span>
            <h3><?= e($room['name']) ?></h3>
            <p><?= e($room['summary']) ?></p>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
      <div class="facilities-inline-note">
        <span class="facilities-inline-note__mark">i</span>
        <p>Room photographs are genuine hospital images, but they do not label the exact room category or air-conditioning status. An enquiry does not reserve a room.</p>
      </div>
    </div>
  </section>

  <section class="facilities-section facilities-section--soft" id="infrastructure">
    <div class="container">
      <div class="facilities-section__heading">
        <div>
          <span class="facilities-eyebrow facilities-eyebrow--blue">03 · Hospital infrastructure</span>
          <h2>Technology and diagnostic services</h2>
          <p>Explore the listed infrastructure and services. Your treating specialist can advise which are relevant to your care.</p>
        </div>
      </div>
      <div class="facilities-card-grid facilities-card-grid--three">
        <?php foreach ($infrastructureFacilities as $item): $photo = $facilityPhotos[$item['id']]; ?>
        <article class="facilities-card" id="<?= e($item['id']) ?>">
          <figure class="facilities-card__media">
            <img src="<?= e(dm_url($photo['src'])) ?>" alt="<?= e($photo['alt']) ?>" loading="lazy" decoding="async">
            <span class="facilities-card__badge">Hospital infrastructure</span>
          </figure>
          <div class="facilities-card__body">
            <span class="facilities-card__icon"><?= icon($item['icon'], 'icon') ?></span>
            <h3><?= e($item['name']) ?></h3>
            <p><?= e($item['summary']) ?></p>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="facilities-section" id="support">
    <div class="container">
      <div class="facilities-section__heading">
        <div>
          <span class="facilities-eyebrow facilities-eyebrow--blue">04 · Patient support</span>
          <h2>Help with the practical details</h2>
          <p>Ask the hospital team about services, processes and the next steps that may apply to your situation.</p>
        </div>
      </div>
      <div class="facilities-card-grid facilities-card-grid--support">
        <?php foreach ($supportFacilities as $item): $photo = $facilityPhotos[$item['id']]; ?>
        <article class="facilities-card facilities-card--support" id="<?= e($item['id']) ?>">
          <figure class="facilities-card__media">
            <img src="<?= e(dm_url($photo['src'])) ?>" alt="<?= e($photo['alt']) ?>" loading="lazy" decoding="async">
            <span class="facilities-card__badge">Patient support</span>
          </figure>
          <div class="facilities-card__body">
            <span class="facilities-card__icon"><?= icon($item['icon'], 'icon') ?></span>
            <h3><?= e($item['name']) ?></h3>
            <p><?= e($item['summary']) ?></p>
            <?php if (in_array($item['id'], ['cashless-insurance-assistance', 'cmrf-guidance'], true)): ?>
            <a class="facilities-card__link" href="<?= e(dm_url('insurance' . ($item['id'] === 'cmrf-guidance' ? '#cmrf-help' : '#empanelment-help'))) ?>">Ask about eligibility <span aria-hidden="true">→</span></a>
            <?php endif; ?>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
      <p class="facilities-photo-note">Some images show a general hospital area rather than the exact service or device. Insurance and CMRF eligibility, approvals and availability depend on the relevant insurer or programme.</p>
    </div>
  </section>

  <section class="facilities-photo-tour">
    <div class="container">
      <div class="facilities-section__heading">
        <div>
          <span class="facilities-eyebrow facilities-eyebrow--blue">A look inside</span>
          <h2>Spaces across the hospital</h2>
          <p>Browse verified photographs of the hospital, its patient areas and diagnostic spaces.</p>
        </div>
        <a class="facilities-text-link" href="<?= e(dm_url('gallery')) ?>">View the full gallery <span aria-hidden="true">→</span></a>
      </div>
      <div class="facilities-photo-grid">
        <?php foreach ($facilityGallery as $photo): ?>
        <figure class="facilities-photo-grid__item">
          <img src="<?= e(dm_url($photo['src'])) ?>" alt="<?= e($photo['alt']) ?>" loading="lazy" decoding="async">
          <figcaption><span></span><?= e($photo['label']) ?></figcaption>
        </figure>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="facilities-visit" id="visit">
    <div class="container facilities-visit__layout">
      <div class="facilities-visit__copy">
        <span class="facilities-eyebrow">Visit or ask us a question</span>
        <h2>Our team can help you plan your visit</h2>
        <p>For current room availability, facility details or help finding the hospital, contact the team before you travel.</p>
        <address>Opp. Ambassador Hotel, beside Sushil Hospital<br>Sangli–Miraj Road, Vishrambag, Sangli, Maharashtra 416415</address>
        <div class="facilities-hero__actions">
          <a class="facilities-button facilities-button--light" href="<?= e(dm_url('contact')) ?>">Contact the hospital <span aria-hidden="true">→</span></a>
          <a class="facilities-button facilities-button--glass" href="tel:<?= e(DM_PHONE) ?>"><?= icon('phone', 'icon icon--sm') ?> <?= e(DM_PHONE_DISPLAY) ?></a>
        </div>
      </div>
      <figure class="facilities-visit__photo">
        <img src="<?= e(dm_url('assets/img/hospital-shoot/hospital-exterior-garden-view.webp')) ?>" alt="Deccan Malti Hospital exterior with the entrance approach" loading="lazy" decoding="async">
        <figcaption>Deccan Malti Hospital · Vishrambag, Sangli</figcaption>
      </figure>
    </div>
  </section>
</div>
