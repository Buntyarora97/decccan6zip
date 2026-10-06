<?php
/** Full services directory shared with the desktop and mobile navigation. */
require_once __DIR__ . '/../includes/breadcrumbs.php';
$serviceCatalog = dm_services();
?>
<section class="page-hero">
  <div class="container">
    <?php dm_breadcrumbs(['Home' => '', 'Services' => null]); ?>
    <h1 style="max-width:820px;">Services &amp; Specialities</h1>
    <p class="lead" style="max-width:760px;">Browse clinical care, diagnostic services and allied support at Deccan Malti Hospital. Each service links to an overview or a consultation request.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <?php foreach ($serviceCatalog as $categoryKey => $category): ?>
    <section class="service-category" id="<?= e($categoryKey) ?>">
      <div class="section__head reveal">
        <span class="eyebrow"><?= e($category['label']) ?></span>
        <h2><?= e($category['label']) ?></h2>
      </div>
      <div class="service-catalog">
        <?php foreach ($category['groups'] as $groupName => $services): ?>
        <section class="service-group reveal">
          <?php if ($categoryKey === 'clinical'): ?><h3><?= e($groupName) ?></h3><?php endif; ?>
          <div class="service-group__cards">
            <?php foreach ($services as $service): ?>
            <article class="service-card" id="service-<?= e($service['id']) ?>">
              <span class="service-card__icon"><?= icon($service['icon'], 'icon') ?></span>
              <h3><?= e($service['name']) ?></h3>
              <p><?= e($service['summary']) ?></p>
              <div class="service-card__actions">
                <?php if (!empty($service['department'])): ?>
                <a href="<?= e(dm_service_url($service)) ?>">Department overview <?= icon('arrow-right', 'icon icon--sm') ?></a>
                <?php endif; ?>
                <a href="<?= e(dm_url('appointment')) ?>">Request a consultation <?= icon('calendar', 'icon icon--sm') ?></a>
              </div>
            </article>
            <?php endforeach; ?>
          </div>
        </section>
        <?php endforeach; ?>
      </div>
    </section>
    <?php endforeach; ?>

    <div class="service-directory__support">
      <p>For urgent symptoms, seek immediate emergency care. For questions about a service, contact the hospital team.</p>
      <a href="<?= e(dm_url('contact')) ?>" class="btn btn--outline">Contact the hospital <?= icon('arrow-right', 'icon icon--sm') ?></a>
      <a href="<?= e(dm_brochure_url()) ?>" download="Deccan-Malti-Hospital-Guide.pdf" class="btn btn--primary"><?= icon('download', 'icon icon--sm') ?> Download Hospital Guide (PDF)</a>
    </div>
    <div style="margin-top:var(--sp-6);"><?php require __DIR__ . '/../includes/cta-strip.php'; ?></div>
  </div>
</section>
