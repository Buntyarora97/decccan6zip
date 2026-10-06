<?php
/**
 * About page — 8 sections.
 */
require_once __DIR__ . '/../includes/breadcrumbs.php';
$doctors = dm_doctors();
?>

<!-- Section 1: Inner hero -->
<section class="page-hero">
  <div class="container page-hero__grid">
    <div>
      <?php dm_breadcrumbs(['Home' => '', 'About Us' => null]); ?>
      <h1>About Deccan Malti</h1>
      <p class="lead">Deccan Malti Hospital — Neuro, ICU &amp; Superspeciality Hospital in Vishrambag, Sangli.</p>
      <div class="page-hero__ctas">
        <a href="<?= e(dm_url('appointment')) ?>" class="btn btn--accent"><?= icon('calendar', 'icon icon--sm') ?> Book Appointment</a>
        <a href="<?= e(dm_url('leadership')) ?>" class="btn btn--ghost-light">Meet Our Founders</a>
        <a href="<?= e(dm_brochure_url()) ?>" download="Deccan-Malti-Hospital-Guide.pdf" class="btn btn--ghost-light"><?= icon('download', 'icon icon--sm') ?> Download Hospital Guide</a>
      </div>
    </div>
    <div class="page-hero__img reveal" style="position:relative;">
      <?= dm_img('assets/img/hospital-shoot/hospital-exterior-front.webp', 'Front-facing daytime view of Deccan Malti Hospital, Sangli', 1800, 1200, '', true) ?>
    </div>
  </div>
</section>

<!-- Section 2: Our beginning -->
<section class="section">
  <div class="container">
    <div class="about-split">
      <div class="reveal">
        <span class="eyebrow">Our Beginning</span>
        <h2>Why we built a superspeciality hospital in Sangli</h2>
        <p>Deccan Malti Neuro &amp; Superspeciality Hospital was founded in March 2023 by Dr. P. C. Patil and Dr. Rohan Patil. The hospital is located on Sangli–Miraj Road in Vishrambag, Sangli.</p>
        <p>Its service directory brings together clinical specialities, diagnostic services and allied support. Patients and families can explore those services here, then contact the hospital team with questions about a visit.</p>
        <p>For current service availability, room categories and appointment arrangements, please confirm directly with the hospital.</p>
      </div>
      <div class="reveal reveal-delay-1">
        <div class="card" style="padding:var(--sp-5);">
          <h3 style="margin-bottom:20px;">Our journey so far</h3>
          <div style="display:flex;flex-direction:column;gap:0;position:relative;padding-left:28px;border-left:2px solid var(--border);">
            <div style="position:relative;padding-bottom:26px;">
              <span style="position:absolute;left:-37px;top:4px;width:16px;height:16px;border-radius:50%;background:var(--teal);border:3px solid var(--white);box-shadow:0 0 0 2px var(--teal);"></span>
              <strong style="font-family:var(--font-head);color:var(--navy);">March 2023</strong>
              <p style="font-size:14px;color:var(--text-soft);margin-top:4px;">Deccan Malti Neuro &amp; Superspeciality Hospital opens its doors in Vishrambag, Sangli — a 45-bedded multi-super-speciality hospital.</p>
            </div>
            <div style="position:relative;padding-bottom:26px;">
              <span style="position:absolute;left:-37px;top:4px;width:16px;height:16px;border-radius:50%;background:var(--teal);border:3px solid var(--white);box-shadow:0 0 0 2px var(--teal);"></span>
              <strong style="font-family:var(--font-head);color:var(--navy);">2023 – 2024</strong>
              <p style="font-size:14px;color:var(--text-soft);margin-top:4px;">The hospital continues to list clinical, diagnostic and allied services for patients and families.</p>
            </div>
            <div style="position:relative;">
              <span style="position:absolute;left:-37px;top:4px;width:16px;height:16px;border-radius:50%;background:var(--yellow);border:3px solid var(--white);box-shadow:0 0 0 2px var(--yellow);"></span>
              <strong style="font-family:var(--font-head);color:var(--navy);">Today</strong>
              <p style="font-size:14px;color:var(--text-soft);margin-top:4px;">Visit the service directory or contact the hospital to ask about current information.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Section 3: Mission, vision, values -->
<section class="section section--soft">
  <div class="container">
    <div class="section__head section__head--center reveal">
      <span class="eyebrow" style="justify-content:center;">What Guides Us</span>
      <h2>Our mission, vision and values</h2>
    </div>
    <div class="grid grid--3">
      <div class="card reveal" style="border-top:4px solid var(--teal);">
        <h3 style="margin-bottom:10px;">Our Mission</h3>
          <p style="color:var(--text-soft);">To provide a local point of access to the clinical, diagnostic and allied services listed by Deccan Malti Hospital.</p>
      </div>
      <div class="card reveal reveal-delay-1" style="border-top:4px solid var(--yellow);">
        <h3 style="margin-bottom:10px;">Our Vision</h3>
          <p style="color:var(--text-soft);">To serve patients and families in Sangli through its listed clinical specialities and support services.</p>
      </div>
      <div class="card reveal reveal-delay-2" style="border-top:4px solid var(--navy);">
        <h3 style="margin-bottom:10px;">Our Promise</h3>
          <p style="color:var(--text-soft);">Patients can ask the clinical team about their care, available options and any recommended next steps.</p>
      </div>
    </div>
    <div class="grid about-values-grid" style="gap:14px;margin-top:var(--sp-4);">
      <?php
      $values = [
        ['Compassion', 'Make space for patients and families to ask questions.', 'hand'],
        ['Clinical Responsibility', 'Ask the clinical team to explain its assessment and recommendations.', 'shield'],
        ['Transparency', 'Ask for clear information about options and associated costs.', 'eye'],
        ['Collaboration', 'Ask whether input from another speciality may be relevant to your care.', 'users'],
        ['Continuous Improvement', 'Share feedback or concerns with the hospital team.', 'pulse'],
      ];
      $vi = 0;
      foreach ($values as $v): ?>
      <div class="card reveal<?= $vi % 3 ? ' reveal-delay-' . ($vi % 3) : '' ?>" style="padding:20px;text-align:center;">
        <span class="bento__icon" style="margin:0 auto 12px;"><?= icon($v[2], 'icon') ?></span>
        <strong style="font-family:var(--font-head);font-size:15px;color:var(--navy);display:block;margin-bottom:6px;"><?= e($v[0]) ?></strong>
        <p style="font-size:13px;color:var(--text-soft);"><?= e($v[1]) ?></p>
      </div>
      <?php $vi++; endforeach; ?>
    </div>
  </div>
</section>

<!-- Section 4: Founders & leadership -->
<section class="section">
  <div class="container">
    <div class="section__head reveal">
      <span class="eyebrow">Founders &amp; Leadership</span>
        <h2>The founders of Deccan Malti</h2>
        <p class="lead">Learn more about the hospital’s founders and the doctor profiles published by Deccan Malti.</p>
    </div>
    <div class="grid grid--2">
      <?php $di=0; foreach ($doctors as $slug => $doc): if (empty($doc['published'])) continue; ?>
      <div class="doctor-card reveal<?= $di ? ' reveal-delay-1' : '' ?>">
        <div class="doctor-card__img" style="aspect-ratio:16/9;"><img src="<?= e(dm_url($doc['image'])) ?>" alt="<?= e($doc['name']) ?>, <?= e($doc['role']) ?>" width="640" height="360" loading="lazy"></div>
        <div class="doctor-card__body">
          <span class="doctor-card__spec"><?= e($doc['role']) ?></span>
          <h3><?= e($doc['name']) ?></h3>
          <p class="doctor-card__quals"><?= e(implode(', ', $doc['qualifications'])) ?> · <?= e($doc['experience']) ?></p>
          <p style="font-size:14.5px;color:var(--text-soft);margin-top:6px;"><?= e($doc['bio'][0] ?? $doc['intro']) ?></p>
          <div class="doctor-card__actions">
            <a href="<?= e(dm_url('doctors/' . $slug)) ?>" class="btn btn--outline btn--sm">Full Profile</a>
            <a href="<?= e(dm_url('appointment')) ?>?doctor=<?= e($slug) ?>" class="btn btn--primary btn--sm">Book Consultation</a>
          </div>
        </div>
      </div>
      <?php $di++; endforeach; ?>
    </div>
    <p style="text-align:center;margin-top:var(--sp-4);"><a href="<?= e(dm_url('leadership')) ?>" class="btn btn--outline">Read the leadership story <?= icon('arrow-right', 'icon icon--sm') ?></a></p>
  </div>
</section>

<!-- Section 5: Clinical philosophy -->
<section class="section section--navy">
  <div class="container">
    <div class="section__head section__head--center reveal">
      <span class="eyebrow" style="justify-content:center;">Patient Information</span>
      <h2>Questions to discuss with your clinician</h2>
      <p class="lead">Care decisions depend on your individual situation. You can ask the clinician to explain the points that matter to you.</p>
    </div>
    <div class="grid about-questions-grid">
      <?php
      $philosophy = [
        ['Your Concern', 'Explain your symptoms, health history and questions.', 'search'],
        ['Available Information', 'Ask how your reports or examination relate to your situation.', 'file'],
        ['Care Options', 'Discuss the purpose, expected benefits, risks and alternatives of a proposed option.', 'users'],
        ['Informed Decisions', 'Ask questions before deciding whether to proceed with a treatment or procedure.', 'document-check'],
        ['Next Steps', 'Confirm follow-up instructions and whom to contact with further questions.', 'check'],
      ];
      $pi = 0;
      foreach ($philosophy as $p): ?>
      <div class="neuro-card reveal<?= $pi % 3 ? ' reveal-delay-' . ($pi % 3) : '' ?>" style="text-align:center;">
        <?= icon($p[2], 'icon') ?>
        <strong><?= e($p[0]) ?></strong>
        <p><?= e($p[1]) ?></p>
      </div>
      <?php $pi++; endforeach; ?>
    </div>
  </div>
</section>

<!-- Section 6: Hospital environment gallery -->
<section class="section section--tint">
  <div class="container">
    <div class="section__head reveal">
      <span class="eyebrow">Our Environment</span>
      <h2>Step inside Deccan Malti</h2>
        <p class="lead">A selection of hospital exterior, interior, pharmacy and diagnostic photographs.</p>
    </div>
    <div class="gallery-grid">
      <figure class="reveal"><img src="<?= e(dm_url('assets/img/hospital-shoot/hospital-exterior-garden-view.webp')) ?>" alt="Daytime exterior view of Deccan Malti Hospital" width="1800" height="1200" loading="lazy"><figcaption>Hospital exterior</figcaption></figure>
      <figure class="reveal reveal-delay-1"><img src="<?= e(dm_url('assets/img/hospital-shoot/hospital-emblem-display.webp')) ?>" alt="Deccan Malti Hospital emblem displayed on an interior wall" width="1800" height="1200" loading="lazy"><figcaption>Hospital emblem display</figcaption></figure>
      <figure class="reveal reveal-delay-2"><img src="<?= e(dm_url('assets/img/hospital-shoot/hospital-corridor.webp')) ?>" alt="Interior corridor at Deccan Malti Hospital" width="1800" height="1200" loading="lazy"><figcaption>Hospital corridor</figcaption></figure>
      <figure class="reveal"><img src="<?= e(dm_url('assets/img/hospital-shoot/pharmacy-entrance.webp')) ?>" alt="Hospital pharmacy entrance with visible 24/7 signage" width="1800" height="1200" loading="lazy"><figcaption>Pharmacy entrance</figcaption></figure>
      <figure class="reveal reveal-delay-1"><img src="<?= e(dm_url('assets/img/hospital-shoot/diagnostic-imaging-room.webp')) ?>" alt="Diagnostic imaging equipment; specific machine is not identified" width="1800" height="1200" loading="lazy"><figcaption>Diagnostic imaging space</figcaption></figure>
      <figure class="reveal reveal-delay-2"><img src="<?= e(dm_url('assets/img/hospital-shoot/zoned-care-area.webp')) ?>" alt="Care area with red and yellow zone signage; room designation is not inferred" width="1800" height="1200" loading="lazy"><figcaption>Care area with zoned signage</figcaption></figure>
    </div>
    <p class="section__footer-link"><a href="<?= e(dm_url('gallery')) ?>" class="btn btn--outline">View the full gallery <?= icon('arrow-right', 'icon icon--sm') ?></a></p>
  </div>
</section>

<!-- Section 7: Infrastructure & patient support -->
<section class="section">
  <div class="container">
    <div class="grid grid--2" style="align-items:start;">
      <div class="reveal">
        <span class="eyebrow">Hospital Infrastructure</span>
        <h2>Facilities for assessment and treatment</h2>
        <div class="prose">
          <ul>
            <li>Modular operation theatre with air-filtration infrastructure.</li>
            <li>Pentero surgical microscope for magnified visualisation during selected procedures.</li>
            <li>CUSA (Cavitron Ultrasonic Surgical Aspirator) technology.</li>
            <li>In-house CT scan and pathology and laboratory services.</li>
            <li>24/7 pharmacy service.</li>
          </ul>
          <p style="margin-top:14px;"><a href="<?= e(dm_url('facilities#infrastructure')) ?>" class="quick-card__link">Explore facilities and infrastructure <?= icon('arrow-right', 'icon icon--sm') ?></a></p>
        </div>
      </div>
      <div class="reveal reveal-delay-1">
        <span class="eyebrow">Patient Support</span>
        <h2>Guidance for care and planning</h2>
        <div class="prose">
          <ul>
            <li>Physiotherapy and rehabilitation department.</li>
            <li>Cashless insurance assistance, subject to policy eligibility and insurer approval.</li>
            <li>Chief Minister’s Relief Fund (CMRF) guidance; eligibility and financial support are subject to programme rules and approval.</li>
            <li>Ask the hospital team to confirm room category and current availability.</li>
          </ul>
          <p style="margin-top:14px;"><a href="<?= e(dm_url('insurance#empanelment-help')) ?>" class="quick-card__link">Insurance and empanelment assistance <?= icon('arrow-right', 'icon icon--sm') ?></a></p>
          <p style="margin-top:14px;"><a href="<?= e(dm_url('patient-care/patient-rights-responsibilities')) ?>" class="quick-card__link">Patient rights &amp; responsibilities <?= icon('arrow-right', 'icon icon--sm') ?></a></p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Section 8: Community + closing CTA -->
<section class="section section--soft">
  <div class="container">
    <div class="section__head section__head--center reveal">
      <span class="eyebrow" style="justify-content:center;">Community</span>
      <h2>Rooted in Sangli, responsible to Sangli</h2>
      <p class="lead">Deccan Malti Hospital is based in Vishrambag, Sangli. Explore the listed services and contact the hospital with questions about planning a visit.</p>
    </div>
    <?php require __DIR__ . '/../includes/cta-strip.php'; ?>
  </div>
</section>
