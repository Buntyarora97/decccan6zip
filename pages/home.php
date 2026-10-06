<?php
/**
 * Homepage — 13 sections (header/footer/cookie/mobile-bar excluded).
 */
$serviceCatalog = dm_services();
$superSpecialities = $serviceCatalog['clinical']['groups']['Super Specialities'];
$doctors = dm_doctors();
$articles = dm_articles();
$articleSlice = array_slice($articles, 0, 3, true);
?>

<div class="hospital-marquee" role="region" aria-label="Hospital information">
  <div class="hospital-marquee__track">
    <?php for ($tickerCopy = 0; $tickerCopy < 2; $tickerCopy++): ?>
    <div class="hospital-marquee__group"<?= $tickerCopy ? ' aria-hidden="true" inert' : '' ?>>
      <span class="hospital-marquee__item hospital-marquee__item--brand"><strong>Deccan Malti</strong> Neuro &amp; Superspeciality Hospital</span>
      <span class="hospital-marquee__item">35-bedded multi-speciality hospital</span>
      <span class="hospital-marquee__item">Specialist departments</span>
       <span class="hospital-marquee__item">Neurosurgery · Cardiology · Orthopaedics</span>
      <span class="hospital-marquee__item">Sangli–Miraj Road · Vishrambag</span>
      <span class="hospital-marquee__item">Call <?= e(DM_PHONE_DISPLAY) ?></span>
    </div>
    <?php endfor; ?>
  </div>
</div>

<!-- ============ SECTION 1: Hospital introduction ============ -->
<section class="hero">
  <div class="container hero__inner hero--photo-split">
    <div class="hero__copy">
      <span class="hero__eyebrow">Deccan Malti Hospital · Sangli</span>
      <h1>Neuro, ICU &amp;<br>Superspeciality<br><span class="accent">Hospital</span></h1>
      <p class="hero__lead">Explore clinical, diagnostic and supportive services, hospital facilities, and practical guidance for planning your visit.</p>
      <div class="hero__ctas">
        <a href="<?= e(dm_url('appointment')) ?>" class="btn btn--accent"><?= icon('calendar', 'icon icon--sm') ?> Book an Appointment</a>
        <a href="<?= e(dm_url('departments')) ?>" class="btn btn--ghost-light">Explore Specialities <?= icon('arrow-right', 'icon icon--sm') ?></a>
        <a href="<?= e(dm_brochure_url()) ?>" download="Deccan-Malti-Hospital-Guide.pdf" class="btn btn--ghost-light"><?= icon('download', 'icon icon--sm') ?> Download Hospital Guide</a>
      </div>
      <div class="hero__chips">
        <span class="chip"><?= icon('map-pin', 'icon icon--sm') ?> Sangli–Miraj Road</span>
        <span class="chip"><?= icon('brain', 'icon icon--sm') ?> Neurosurgery</span>
        <span class="chip"><?= icon('scan', 'icon icon--sm') ?> Diagnostic services</span>
      </div>
    </div>

    <div class="hero__photo-frame">
      <img src="<?= e(dm_url('assets/img/hospital-shoot/hospital-exterior-garden-view.webp')) ?>"
           alt="Daytime view of the Deccan Malti Hospital building from the entrance approach"
           width="1800" height="1200" fetchpriority="high" decoding="async">
      <p class="hero__photo-caption">Deccan Malti Hospital · Vishrambag, Sangli</p>
    </div>
  </div>
</section>

<!-- ============ SECTION 2: Quick care gateway ============ -->
<section class="section" style="padding-top:0;">
  <div class="container">
    <div class="quick-cards" id="quick-care-actions">
      <a href="<?= e(dm_url('appointment')) ?>" class="quick-card quick-card--appointment reveal">
        <span class="quick-card__icon"><?= icon('calendar', 'icon') ?></span>
        <strong>Book Appointment</strong>
        <p>Request a consultation slot online — our team confirms by phone.</p>
        <span class="quick-card__link">Request slot <?= icon('arrow-right', 'icon icon--sm') ?></span>
      </a>
      <a href="<?= e(dm_url('doctors')) ?>" class="quick-card quick-card--specialist reveal reveal-delay-1">
        <span class="quick-card__icon"><?= icon('stetho', 'icon') ?></span>
        <strong>Find a Specialist</strong>
        <p>Explore the hospital’s listed specialist departments.</p>
        <span class="quick-card__link">Meet doctors <?= icon('arrow-right', 'icon icon--sm') ?></span>
      </a>
      <a href="tel:<?= e(DM_PHONE) ?>" class="quick-card quick-card--call reveal reveal-delay-2">
        <span class="quick-card__icon"><?= icon('phone', 'icon') ?></span>
        <strong>Call the Hospital</strong>
        <p><?= e(DM_PHONE_DISPLAY) ?> · Landline <?= e(DM_LANDLINE_DISPLAY) ?></p>
        <span class="quick-card__link">Call now <?= icon('arrow-right', 'icon icon--sm') ?></span>
      </a>
      <a href="<?= e(DM_MAPS_URL) ?>" target="_blank" rel="noopener" class="quick-card quick-card--directions reveal reveal-delay-3">
        <span class="quick-card__icon"><?= icon('map-pin', 'icon') ?></span>
        <strong>Get Directions</strong>
        <p>Opp. Ambassador Hotel, Vishrambag, Sangli–Miraj Road.</p>
        <span class="quick-card__link">Open map <?= icon('arrow-right', 'icon icon--sm') ?></span>
      </a>
    </div>
    <div class="emergency-note reveal">
      <?= icon('alert', 'icon') ?>
      <span><strong>Medical emergency?</strong> For life-threatening emergencies, call local emergency services or go to the nearest emergency facility immediately.</span>
    </div>
  </div>
</section>

<!-- ============ SECTION 3: About the hospital ============ -->
<section class="section section--soft">
  <div class="container about-split">
    <div class="about-media reveal">
      <div class="about-media__img">
        <?= dm_img('assets/img/hospital-shoot/hospital-exterior.webp', 'Daytime view of Deccan Malti Hospital, Sangli', 1800, 1200) ?>
      </div>
      <span class="timeline-badge">Since March 2023</span>
      <div class="fact-card">
        <span class="fact-card__num" data-count="35">0</span>
        <small>Bedded multi-super-<br>speciality hospital</small>
      </div>
    </div>
    <div class="reveal reveal-delay-1">
      <span class="eyebrow">About Deccan Malti</span>
      <h2>Specialist care that treats you like a person, not a case</h2>
      <p class="lead">Founded in March 2023 by Dr. P. C. Patil and Dr. Rohan Patil, Deccan Malti Hospital is located in Vishrambag, Sangli.</p>
      <p>Explore the hospital’s clinical, diagnostic and allied services, meet its listed doctors, or contact the team about planning a visit.</p>
        <p style="margin-top:16px;display:flex;flex-wrap:wrap;gap:10px;">
          <a href="<?= e(dm_url('about')) ?>" class="btn btn--primary">Our Story <?= icon('arrow-right', 'icon icon--sm') ?></a>
          <a href="<?= e(dm_brochure_url()) ?>" download="Deccan-Malti-Hospital-Guide.pdf" class="btn btn--outline"><?= icon('download', 'icon icon--sm') ?> Download Hospital Guide</a>
        </p>
    </div>
  </div>
</section>

<!-- ============ SECTION 4: Super specialities ============ -->
<section class="section" id="specialities">
  <div class="container">
    <div class="section__head section__head--center reveal">
      <span class="eyebrow" style="justify-content:center;">Specialities</span>
      <h2>Our Super Specialities</h2>
      <p class="lead">Explore nine specialist services and request a consultation for the care you need.</p>
    </div>
    <div class="specialty-grid">
      <?php foreach ($superSpecialities as $service): ?>
      <article class="specialty-card reveal" id="speciality-<?= e($service['id']) ?>">
        <span class="bento__icon"><?= icon($service['icon'], 'icon') ?></span>
        <h3><?= e($service['name']) ?></h3>
        <p><?= e($service['summary']) ?></p>
        <a href="<?= e(dm_service_url($service)) ?>">Explore service <?= icon('arrow-right', 'icon icon--sm') ?></a>
      </article>
      <?php endforeach; ?>
    </div>
    <p class="section__footer-link"><a href="<?= e(dm_url('departments')) ?>" class="btn btn--outline">View the full service directory <?= icon('arrow-right', 'icon icon--sm') ?></a></p>
  </div>
</section>

<!-- ============ SECTION 5: Complete service scope ============ -->
<section class="section section--soft" id="scope-of-services">
  <div class="container">
    <div class="section__head reveal">
      <span class="eyebrow">Care &amp; Support</span>
      <h2>Scope of Services</h2>
      <p class="lead">Browse clinical care, diagnostic investigations and allied services in one directory.</p>
    </div>
    <div class="scope-grid">
      <?php foreach ($serviceCatalog as $categoryKey => $category): ?>
      <section class="scope-card reveal">
        <span class="bento__icon"><?= icon($category['icon'], 'icon') ?></span>
        <h3><?= e($category['label']) ?></h3>
        <?php foreach ($category['groups'] as $groupName => $items): ?>
        <?php if ($categoryKey === 'clinical'): ?><h4><?= e($groupName) ?></h4><?php endif; ?>
        <ul class="scope-card__links">
          <?php foreach ($items as $service): ?>
          <li><a href="<?= e(dm_service_url($service)) ?>"><?= e($service['name']) ?></a></li>
          <?php endforeach; ?>
        </ul>
        <?php endforeach; ?>
        <a href="<?= e(dm_url('departments#' . $categoryKey)) ?>" class="scope-card__more">Service information <?= icon('arrow-right', 'icon icon--sm') ?></a>
      </section>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ SECTION 6: Neuro centre feature ============ -->
<section class="section section--navy" id="neuro-centre">
  <div class="container">
    <div class="reveal">
      <span class="eyebrow">Signature Centre</span>
      <h2>Centre for Brain, Spine &amp; Neurological Care</h2>
      <p class="lead">Explore Neurosurgery and Neurology services, and discuss symptoms or evaluation with a clinician.</p>
      <div class="neuro-cards">
        <div class="neuro-card"><?= icon('brain', 'icon') ?><strong>Neurosurgery</strong><p>Specialist assessment for conditions affecting the brain and spine.</p></div>
        <div class="neuro-card"><?= icon('pulse', 'icon') ?><strong>Neurology</strong><p>Medical evaluation for concerns involving the nervous system.</p></div>
        <div class="neuro-card"><?= icon('scan', 'icon') ?><strong>Diagnostic services</strong><p>Imaging and investigations may support a clinician's assessment.</p></div>
        <div class="neuro-card"><?= icon('hand', 'icon') ?><strong>Rehabilitation support</strong><p>Ask the care team about physiotherapy and rehabilitation services.</p></div>
      </div>
      <p style="margin-top:22px;"><a href="<?= e(dm_url('departments/neurosurgery')) ?>" class="btn btn--accent">Neurosurgery overview <?= icon('arrow-right', 'icon icon--sm') ?></a></p>
      <div class="medical-note">
        <?= icon('info', 'icon icon--sm') ?>
        <span>Website information does not replace medical advice. Seek immediate emergency care for urgent symptoms.</span>
      </div>
    </div>
  </div>
</section>

<!-- ============ SECTION 7: Hospital overview ============ -->
<section class="section section--soft">
  <div class="container">
    <div class="section__head reveal">
      <span class="eyebrow">Hospital Overview</span>
      <h2>Services, leadership and patient support</h2>
    </div>
    <div class="bento">
      <div class="bento__item bento__item--navy reveal">
        <span class="bento__icon"><?= icon('bed', 'icon') ?></span>
        <span class="counter" data-count="35">0</span><span class="counter-suffix" style="font-size:24px;font-weight:800;"> beds</span>
        <p style="margin-top:8px;">Deccan Malti Hospital’s published bed capacity.</p>
      </div>
      <div class="bento__item reveal reveal-delay-1">
        <span class="bento__icon"><?= icon('users', 'icon') ?></span>
        <strong>Clinical services</strong>
        <p>Explore the listed super-specialities, other specialities and diagnostic services.</p>
      </div>
      <div class="bento__item reveal reveal-delay-2">
        <span class="bento__icon"><?= icon('shield', 'icon') ?></span>
        <strong>Hospital leadership</strong>
        <p>Read about co-founders Dr. P. C. Patil and Dr. Rohan Patil.</p>
      </div>
      <div class="bento__item reveal">
        <span class="bento__icon"><?= icon('hand', 'icon') ?></span>
        <strong>Patient information</strong>
        <p>Find appointment, admission, visitor and medical-record guidance before your visit.</p>
      </div>
      <div class="bento__item reveal reveal-delay-1">
        <span class="bento__icon"><?= icon('microscope', 'icon') ?></span>
        <strong>Diagnostic &amp; support services</strong>
        <p>Review diagnostic, pharmacy and rehabilitation services listed by the hospital.</p>
      </div>
      <div class="bento__item bento__item--yellow reveal reveal-delay-2">
        <span class="bento__icon"><?= icon('map-pin', 'icon') ?></span>
        <strong>Vishrambag, Sangli</strong>
        <p>Find the hospital on Sangli–Miraj Road, opposite Ambassador Hotel and beside Sushil Hospital.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ SECTION 8: Meet the listed doctors ============ -->
<section class="section">
  <div class="container">
    <div class="section__head reveal" style="display:flex;justify-content:space-between;align-items:flex-end;gap:20px;max-width:none;flex-wrap:wrap;">
      <div style="max-width:640px;">
        <span class="eyebrow">Our Specialists</span>
        <h2>Meet the hospital’s listed doctors</h2>
      </div>
      <div style="display:flex;gap:10px;">
        <button class="orbit-btn doctors-prev" aria-label="Previous doctors" style="background:var(--white);border:1px solid var(--border);"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 6l-6 6 6 6"/></svg></button>
        <button class="orbit-btn doctors-next" aria-label="Next doctors" style="background:var(--white);border:1px solid var(--border);"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 6l6 6-6 6"/></svg></button>
      </div>
    </div>
    <div class="swiper doctors-swiper reveal">
      <div class="swiper-wrapper">
        <?php foreach ($doctors as $slug => $doc): if (empty($doc['published'])) continue; ?>
        <div class="swiper-slide">
          <div class="doctor-card">
            <div class="doctor-card__img">
              <img src="<?= e(dm_url($doc['image'])) ?>" alt="<?= e($doc['image_alt'] ?? ($doc['name'] . ', ' . $doc['speciality'] . ' at Deccan Malti Hospital, Sangli')) ?>" width="480" height="400" loading="lazy">
            </div>
            <div class="doctor-card__body">
              <span class="doctor-card__spec"><?= e($doc['speciality']) ?></span>
              <h3><?= e($doc['name']) ?></h3>
              <p class="doctor-card__quals"><?= e(implode(', ', $doc['qualifications'])) ?></p>
              <p class="doctor-card__exp"><?= e($doc['experience']) ?></p>
              <div class="doctor-card__actions">
                <a href="<?= e(dm_url('doctors/' . $slug)) ?>" class="btn btn--outline btn--sm">View Profile</a>
                <a href="<?= e(dm_url('appointment')) ?>?doctor=<?= e($slug) ?>" class="btn btn--primary btn--sm">Book</a>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="doctors-dots" style="display:flex;justify-content:center;gap:6px;margin-top:24px;"></div>
    </div>
  </div>
</section>

<!-- ============ SECTION 9: Facilities, accommodation and gallery preview ============ -->
<section class="section section--tint">
  <div class="container">
    <?php $facilityData = dm_facilities(); ?>
    <div class="facility-intro">
      <div class="section__head reveal">
        <span class="eyebrow">Hospital Facilities</span>
        <h2>Care spaces and practical support</h2>
        <p class="lead">Explore emergency and critical-care categories, inpatient accommodation and hospital support services.</p>
        <p class="facility-intro__actions">
          <a href="<?= e(dm_url('facilities')) ?>" class="btn btn--primary">Explore all facilities <?= icon('arrow-right', 'icon icon--sm') ?></a>
          <a href="<?= e(dm_brochure_url()) ?>" download="Deccan-Malti-Hospital-Guide.pdf" class="btn btn--outline"><?= icon('download', 'icon icon--sm') ?> Hospital guide (PDF)</a>
        </p>
      </div>
      <figure class="facility-intro__photo reveal">
        <img src="<?= e(dm_url('assets/img/hospital-shoot/zoned-care-area.webp')) ?>" alt="Hospital care area with red and yellow zone signs; the specific room designation is not inferred from the photograph" width="1800" height="1200" loading="lazy" decoding="async">
        <figcaption>Care area with red and yellow zone signage</figcaption>
      </figure>
    </div>

    <div class="section__head reveal">
      <span class="eyebrow">Emergency &amp; Critical Care</span>
      <h3>Care categories</h3>
    </div>
    <div class="facility-feature-grid">
      <?php foreach ($facilityData['critical_care'] as $facility): ?>
      <article class="facility-card reveal" id="home-<?= e($facility['id']) ?>">
        <span class="bento__icon"><?= icon($facility['icon'], 'icon') ?></span>
        <h3><?= e($facility['name']) ?></h3>
        <p><?= e($facility['summary']) ?></p>
      </article>
      <?php endforeach; ?>
    </div>

    <div class="section__head reveal" style="margin-top:var(--sp-6);">
      <span class="eyebrow">Rooms &amp; Accommodation</span>
      <h3>Choose a room category with the hospital team</h3>
      <p class="lead">Room type and current availability are confirmed by the hospital. A website enquiry does not reserve a room.</p>
    </div>
    <div class="room-grid">
      <?php foreach ($facilityData['rooms'] as $room): ?>
      <article class="room-card reveal" id="home-<?= e($room['id']) ?>">
        <?= icon($room['icon'], 'icon icon--sm') ?>
        <h3><?= e($room['name']) ?></h3>
        <p><?= e($room['summary']) ?></p>
      </article>
      <?php endforeach; ?>
    </div>

    <div class="section__head reveal" style="margin-top:var(--sp-6);">
      <span class="eyebrow">Infrastructure &amp; Patient Support</span>
      <h3>Hospital services and equipment</h3>
    </div>
    <div class="infrastructure-grid infrastructure-grid--compact">
      <?php foreach ($facilityData['infrastructure'] as $item): ?>
      <article class="reveal">
        <span class="bento__icon"><?= icon($item['icon'], 'icon') ?></span>
        <h3><?= e($item['name']) ?></h3>
        <p><?= e($item['summary']) ?></p>
      </article>
      <?php endforeach; ?>
    </div>

    <div class="section__head reveal" style="margin-top:var(--sp-6);">
      <span class="eyebrow">Hospital Gallery</span>
      <h3>A look at the hospital’s spaces</h3>
    </div>
    <div class="home-photo-grid">
      <figure class="reveal"><img src="<?= e(dm_url('assets/img/hospital-shoot/hospital-exterior-front.webp')) ?>" alt="Front-facing view of the Deccan Malti Hospital building" width="1800" height="1200" loading="lazy"><figcaption>Hospital exterior</figcaption></figure>
      <figure class="reveal reveal-delay-1"><img src="<?= e(dm_url('assets/img/hospital-shoot/pharmacy-entrance.webp')) ?>" alt="Deccan Malti Hospital pharmacy entrance with visible 24/7 pharmacy signage" width="1800" height="1200" loading="lazy"><figcaption>Pharmacy entrance</figcaption></figure>
      <figure class="reveal reveal-delay-2"><img src="<?= e(dm_url('assets/img/hospital-shoot/diagnostic-imaging-room.webp')) ?>" alt="Diagnostic imaging equipment in a hospital room; the specific machine is not identified" width="1800" height="1200" loading="lazy"><figcaption>Diagnostic imaging space</figcaption></figure>
    </div>
    <p class="section__footer-link">
      <a href="<?= e(dm_url('gallery')) ?>" class="btn btn--outline">View the complete gallery <?= icon('arrow-right', 'icon icon--sm') ?></a>
      <a href="<?= e(dm_url('contact')) ?>" class="btn btn--primary">Ask about a facility <?= icon('arrow-right', 'icon icon--sm') ?></a>
    </p>
  </div>
</section>

<!-- ============ SECTION 10: Care journey ============ -->
<section class="section">
  <div class="container">
    <div class="section__head section__head--center reveal">
      <span class="eyebrow" style="justify-content:center;">Your Care Journey</span>
      <h2>Planning a hospital visit</h2>
    </div>
    <div class="journey">
      <div class="journey__line"><div class="journey__line-fill"></div></div>
      <div class="journey__steps">
        <div class="journey-step reveal"><span class="journey-step__dot"><?= icon('search', 'icon') ?><span class="journey-step__num">1</span></span><div><strong>Explore Services</strong><p>Review the service directory and choose the department you want to ask about.</p></div></div>
        <div class="journey-step reveal reveal-delay-1"><span class="journey-step__dot"><?= icon('calendar', 'icon') ?><span class="journey-step__num">2</span></span><div><strong>Send an Appointment Request</strong><p>Use the appointment form or call the hospital team.</p></div></div>
        <div class="journey-step reveal reveal-delay-2"><span class="journey-step__dot"><?= icon('phone', 'icon') ?><span class="journey-step__num">3</span></span><div><strong>Confirm the Details</strong><p>Contact the hospital to confirm timing, availability and what to bring.</p></div></div>
        <div class="journey-step reveal reveal-delay-2"><span class="journey-step__dot"><?= icon('stetho', 'icon') ?><span class="journey-step__num">4</span></span><div><strong>Meet the Clinician</strong><p>Bring relevant reports and discuss your concern with a qualified clinician.</p></div></div>
        <div class="journey-step reveal reveal-delay-3"><span class="journey-step__dot"><?= icon('check', 'icon') ?><span class="journey-step__num">5</span></span><div><strong>Discuss Next Steps</strong><p>Your clinician can explain the next steps for your individual situation.</p></div></div>
      </div>
    </div>
    <div class="bring-card reveal">
      <h3><?= icon('document-check', 'icon icon--sm') ?> What to bring to your first visit</h3>
      <ul>
        <li><?= icon('check', 'icon') ?> A photo ID of the patient</li>
        <li><?= icon('check', 'icon') ?> Previous reports, scans and prescriptions</li>
        <li><?= icon('check', 'icon') ?> List of current medicines</li>
        <li><?= icon('check', 'icon') ?> Insurance card &amp; policy documents, if applicable</li>
      </ul>
    </div>
  </div>
</section>

<!-- ============ SECTION 11: Insurance & patient assistance ============ -->
<section class="section section--soft">
  <div class="container">
    <div class="section__head reveal">
      <span class="eyebrow">Insurance &amp; Assistance</span>
      <h2>Ask about insurance and cashless assistance</h2>
      <p class="lead">Contact the hospital team to ask about policy-specific empanelment and the cashless process. Eligibility, coverage and approval depend on your insurer and policy.</p>
    </div>
    <div class="insurance-steps">
      <div class="insurance-step reveal"><strong>Share your policy details</strong><p>Have your insurance card and policy information available when you enquire.</p></div>
      <div class="insurance-step reveal reveal-delay-1"><strong>Check current network status</strong><p>Ask the hospital team to confirm policy-specific empanelment for your enquiry.</p></div>
      <div class="insurance-step reveal reveal-delay-2"><strong>Ask your insurer about coverage</strong><p>Your insurer can explain coverage, documentation and pre-authorisation requirements.</p></div>
      <div class="insurance-step reveal reveal-delay-3"><strong>Confirm before planning</strong><p>Do not assume approval or coverage; confirm arrangements with the insurer and hospital.</p></div>
    </div>
    <div class="partner-placeholder reveal" style="margin-top:28px;">
      <?= icon('info', 'icon') ?>
      <p style="margin-top:8px;">Insurer and TPA network status can vary by policy and treatment. No partner or approval is implied by this website.</p>
    </div>
    <p style="text-align:center;margin-top:24px;"><a href="<?= e(dm_url('insurance#empanelment-help')) ?>" class="btn btn--primary">Insurance &amp; Empanelment Assistance <?= icon('arrow-right', 'icon icon--sm') ?></a></p>
  </div>
</section>

<!-- ============ SECTION 12: Patient voices ============ -->
<section class="section">
  <div class="container">
    <div class="section__head section__head--center reveal">
      <span class="eyebrow" style="justify-content:center;">Patient Voices</span>
      <h2>Stories from our patients</h2>
    </div>
    <p class="lead" style="max-width:640px;margin:0 auto 20px;text-align:center;">Read genuine, unedited feedback directly on Google.</p>
    <?php require __DIR__ . '/../includes/google-reviews-card.php'; ?>
    <p style="text-align:center;margin-top:22px;"><a href="<?= e(dm_url('testimonials')) ?>" class="btn btn--outline">About our testimonial policy <?= icon('arrow-right', 'icon icon--sm') ?></a></p>
  </div>
</section>

<!-- ============ SECTION 13: Blog + final CTA ============ -->
<section class="section section--tint">
  <div class="container">
    <div class="insights-split">
      <div>
        <div class="section__head reveal">
          <span class="eyebrow">Health Insights</span>
          <h2>Practical health guides</h2>
        </div>
        <div style="display:flex;flex-direction:column;gap:16px;">
          <?php $d=0; foreach ($articleSlice as $slug => $a): ?>
          <a href="<?= e(dm_url('health-library/' . $slug)) ?>" class="article-card reveal<?= $d ? ' reveal-delay-' . $d : '' ?>">
            <div class="article-card__img article-card__img--icon" aria-hidden="true"><?= icon('document-check', 'icon') ?></div>
            <div class="article-card__body">
              <span class="article-card__cat"><?= e($a['category']) ?></span>
              <h3><?= e($a['title']) ?></h3>
              <p class="article-card__meta">Updated <?= e(date('M Y', strtotime($a['updated']))) ?> · <?= e($a['readtime']) ?></p>
            </div>
          </a>
          <?php $d++; endforeach; ?>
        </div>
        <p style="margin-top:20px;"><a href="<?= e(dm_url('health-library')) ?>" class="quick-card__link">Browse all articles <?= icon('arrow-right', 'icon icon--sm') ?></a></p>
      </div>
      <aside class="cta-panel reveal reveal-delay-1">
        <h3>Book an Appointment</h3>
        <p>Request an appointment online or call the hospital to ask about a suitable time.</p>
        <a href="<?= e(dm_url('appointment')) ?>" class="btn btn--accent"><?= icon('calendar', 'icon icon--sm') ?> Request Appointment</a>
        <a href="tel:<?= e(DM_PHONE) ?>" class="btn btn--ghost-light"><?= icon('phone', 'icon icon--sm') ?> <?= e(DM_PHONE_DISPLAY) ?></a>
        <a href="<?= e(DM_MAPS_URL) ?>" target="_blank" rel="noopener" class="btn btn--ghost-light"><?= icon('map-pin', 'icon icon--sm') ?> Get Directions</a>
        <p class="cta-panel__line">Mon–Sat OPD · timings confirmed on booking</p>
      </aside>
    </div>
    <p class="closing-line reveal">The right specialist is <em>one conversation away.</em></p>
  </div>
</section>
