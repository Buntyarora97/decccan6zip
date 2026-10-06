<?php
/** Complete services directory, sourced from the shared public catalogue. */
require_once __DIR__ . '/../includes/breadcrumbs.php';

$serviceCatalog = dm_services();
$serviceCategoryCounts = [];
$serviceCount = 0;
foreach ($serviceCatalog as $categoryKey => $category) {
    $categoryCount = 0;
    foreach ($category['groups'] as $services) {
        $categoryCount += count($services);
    }
    $serviceCategoryCounts[$categoryKey] = $categoryCount;
    $serviceCount += $categoryCount;
}

$serviceCategoryDescriptions = [
    'clinical' => 'Browse specialist departments and clinical consultations across a range of health concerns.',
    'diagnostic' => 'Explore the imaging, tests and laboratory services listed by the hospital.',
    'allied' => 'Find supportive services and contact the hospital team to confirm current arrangements.',
];
?>
<section class="page-hero page-hero--services" aria-labelledby="servicesPageTitle">
  <div class="container page-hero__grid services-hero__grid">
    <div class="services-hero__copy">
      <?php dm_breadcrumbs(['Home' => '', 'Services' => null]); ?>
      <span class="services-hero__eyebrow">Specialist care in Sangli</span>
      <h1 id="servicesPageTitle">Services &amp; Specialities</h1>
      <p class="lead">Explore the clinical departments, diagnostic services and patient support services listed at Deccan Malti Hospital.</p>
      <p class="services-hero__supporting">Use the directory to compare service summaries, open a department overview, or request a consultation. For current availability and appointment details, contact the hospital team.</p>
      <div class="page-hero__ctas services-hero__ctas">
        <a href="#service-catalogue" class="btn btn--primary">Browse all <?= e((string) $serviceCount) ?> services <?= icon('arrow-right', 'icon icon--sm') ?></a>
        <a href="<?= e(dm_url('appointment')) ?>" class="btn btn--outline">Request a consultation <?= icon('calendar', 'icon icon--sm') ?></a>
      </div>
    </div>

    <figure class="services-hero__image">
      <img
        src="<?= e(dm_url('assets/img/hospital-shoot/diagnostic-imaging-room.webp')) ?>"
        alt="Diagnostic imaging room at Deccan Malti Hospital"
        width="1024"
        height="683"
        fetchpriority="high"
      >
      <figcaption>Diagnostic imaging at Deccan Malti Hospital</figcaption>
    </figure>
  </div>

  <nav class="container services-quicklinks" aria-label="Browse services by category">
    <?php foreach ($serviceCatalog as $categoryKey => $category): ?>
    <a class="services-quicklink" href="#<?= e($categoryKey) ?>">
      <span class="services-quicklink__icon"><?= icon($category['icon'], 'icon') ?></span>
      <span class="services-quicklink__copy">
        <strong><?= e($category['label']) ?></strong>
        <small><?= e((string) $serviceCategoryCounts[$categoryKey]) ?> listed services</small>
      </span>
      <?= icon('arrow-right', 'icon icon--sm services-quicklink__arrow') ?>
    </a>
    <?php endforeach; ?>
  </nav>
</section>

<section class="section services-directory" id="service-catalogue" aria-labelledby="serviceDirectoryTitle">
  <div class="container">
    <header class="services-directory__intro">
      <div>
        <span class="eyebrow">Explore the directory</span>
        <h2 id="serviceDirectoryTitle">Find the service you need</h2>
        <p>Search by speciality or service name, or browse the categories below. Each description is a general overview; the treating clinician will advise on individual care.</p>
      </div>
      <div class="services-search">
        <label for="serviceSearch">Search services</label>
        <div class="services-search__field">
          <?= icon('search', 'icon') ?>
          <input
            type="search"
            id="serviceSearch"
            name="serviceSearch"
            placeholder="Try neurology, CT scan, pharmacy…"
            autocomplete="off"
            aria-controls="serviceCatalogue"
          >
        </div>
        <p id="serviceSearchStatus" class="services-search__status" aria-live="polite">Showing all <?= e((string) $serviceCount) ?> services.</p>
      </div>
    </header>

    <div class="services-catalogue" id="serviceCatalogue">
      <?php foreach ($serviceCatalog as $categoryKey => $category): ?>
      <?php $singleGroup = count($category['groups']) === 1; ?>
      <section
        class="service-category<?= $singleGroup ? ' service-category--single' : '' ?>"
        id="<?= e($categoryKey) ?>"
        data-service-category
        aria-labelledby="serviceCategory-<?= e($categoryKey) ?>"
      >
        <header class="services-category__head">
          <div class="services-category__title">
            <span class="services-category__icon"><?= icon($category['icon'], 'icon') ?></span>
            <div>
              <span class="services-category__eyebrow"><?= e($category['label']) ?></span>
              <h2 id="serviceCategory-<?= e($categoryKey) ?>"><?= e($category['label']) ?></h2>
              <p><?= e($serviceCategoryDescriptions[$categoryKey] ?? 'Browse the services listed by the hospital.') ?></p>
            </div>
          </div>
          <span class="services-category__count"><?= e((string) $serviceCategoryCounts[$categoryKey]) ?> services</span>
        </header>

        <div class="service-catalog<?= $singleGroup ? ' service-catalog--single' : '' ?>">
          <?php foreach ($category['groups'] as $groupName => $services): ?>
          <section class="service-group" data-service-group aria-label="<?= e($groupName) ?>">
            <?php if (!$singleGroup): ?>
            <header class="service-group__head">
              <h3><?= e($groupName) ?></h3>
              <span><?= e((string) count($services)) ?> services</span>
            </header>
            <?php endif; ?>
            <div class="service-group__cards">
              <?php foreach ($services as $service): ?>
              <article
                class="service-card"
                id="service-<?= e($service['id']) ?>"
                data-service-card
                data-search="<?= e($service['name'] . ' ' . $service['summary'] . ' ' . $category['label'] . ' ' . $groupName) ?>"
              >
                <span class="service-card__icon"><?= icon($service['icon'], 'icon') ?></span>
                <h3><?= e($service['name']) ?></h3>
                <p><?= e($service['summary']) ?></p>
                <div class="service-card__actions">
                  <?php if (!empty($service['department'])): ?>
                  <a href="<?= e(dm_service_url($service)) ?>" class="service-card__link">Department overview <?= icon('arrow-right', 'icon icon--sm') ?></a>
                  <?php endif; ?>
                  <a href="<?= e(dm_url('appointment')) ?>" class="service-card__book">Request a consultation <?= icon('calendar', 'icon icon--sm') ?></a>
                </div>
              </article>
              <?php endforeach; ?>
            </div>
          </section>
          <?php endforeach; ?>
        </div>
      </section>
      <?php endforeach; ?>
    </div>

    <p class="services-empty-state" id="serviceNoResults" hidden>No services match that search. Try another speciality or service name.</p>

    <section class="services-visit" aria-labelledby="servicesVisitTitle">
      <figure class="services-visit__photo">
        <img
          src="<?= e(dm_url('assets/img/hospital-shoot/hospital-interior-room.webp')) ?>"
          alt="Consultation room at Deccan Malti Hospital"
          width="1800"
          height="1200"
          loading="eager"
          decoding="async"
        >
        <figcaption>A consultation room at Deccan Malti Hospital</figcaption>
      </figure>
      <div class="services-visit__content">
        <span class="eyebrow">Plan your visit</span>
        <h2 id="servicesVisitTitle">Before your consultation</h2>
        <p>A little preparation can help you discuss your concerns with the clinical team. If you have questions about appointment times, service availability or test instructions, please confirm them with the hospital before travelling.</p>
        <ul class="services-visit__list">
          <li><?= icon('check', 'icon') ?><span>Bring relevant previous prescriptions, reports or scans, if available.</span></li>
          <li><?= icon('check', 'icon') ?><span>Keep a current medicine list and share relevant health history with your clinician.</span></li>
          <li><?= icon('check', 'icon') ?><span>Ask the hospital team whether your appointment or test requires any specific preparation.</span></li>
        </ul>
        <a class="services-visit__phone" href="tel:<?= e(DM_LANDLINE) ?>"><?= icon('phone', 'icon icon--sm') ?> Call <?= e(DM_LANDLINE_DISPLAY) ?> to confirm details</a>
      </div>
    </section>

    <section class="services-faq" aria-labelledby="servicesFaqTitle">
      <header class="services-faq__head">
        <span class="eyebrow">Helpful information</span>
        <h2 id="servicesFaqTitle">Common questions about hospital services</h2>
        <p>For service-specific details, please contact the hospital team.</p>
      </header>
      <div class="services-faq__list">
        <details class="services-faq__item">
          <summary>How can I find the right department?</summary>
          <p>Browse the service categories or search this directory. Department overview links provide additional information where available. If you are unsure, contact the hospital to discuss appointment options.</p>
        </details>
        <details class="services-faq__item">
          <summary>How do I confirm appointments and service availability?</summary>
          <p>Scheduling and availability can vary. Call the hospital team before your visit to confirm the current arrangements for the service you need.</p>
        </details>
        <details class="services-faq__item">
          <summary>Do I need to prepare for a diagnostic test?</summary>
          <p>Preparation depends on the specific test and clinical instructions. Please confirm any requirements with the hospital when arranging your test.</p>
        </details>
      </div>
    </section>

    <div class="services-directory__note" role="note">
      <?= icon('info', 'icon') ?>
      <p>Information on this page is for general guidance and is not a diagnosis or treatment plan. Please seek immediate emergency care for urgent symptoms.</p>
    </div>

    <div class="service-directory__support">
      <p>Need help with a service, appointment or hospital visit? Contact the hospital team directly.</p>
      <a href="<?= e(dm_url('contact')) ?>" class="btn btn--outline">Contact the hospital <?= icon('arrow-right', 'icon icon--sm') ?></a>
      <a href="<?= e(dm_brochure_url()) ?>" download="Deccan-Malti-Hospital-Guide.pdf" class="btn btn--primary"><?= icon('download', 'icon icon--sm') ?> Download Hospital Guide (PDF)</a>
    </div>
    <div class="services-directory__cta"><?php require __DIR__ . '/../includes/cta-strip.php'; ?></div>
  </div>
</section>
