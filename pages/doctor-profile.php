<?php
/** Individual doctor profile — vars: $doctor, $slug */
require_once __DIR__ . '/../includes/breadcrumbs.php';
echo dm_schema_physician($doctor);
echo dm_schema_faq($doctor['faqs']);
?>
<section class="page-hero">
  <div class="container doctor-hero">
    <div class="doctor-hero__img reveal">
       <img src="<?= e(dm_url($doctor['image'])) ?>" alt="<?= e($doctor['image_alt'] ?? ($doctor['name'] . ', ' . $doctor['speciality'] . ' at Deccan Malti Hospital, Sangli')) ?>" width="480" height="560" fetchpriority="high">
    </div>
    <div>
      <?php dm_breadcrumbs(['Home' => '', 'Doctors' => 'doctors', $doctor['name'] => null]); ?>
      <h1><?= e($doctor['name']) ?></h1>
      <p class="lead" style="font-family:var(--font-head);font-weight:600;"><?= e($doctor['role']) ?></p>
      <div class="cred-list">
        <?php foreach ($doctor['qualifications'] as $q): ?><span class="chip"><?= icon('document-check', 'icon icon--sm') ?> <?= e($q) ?></span><?php endforeach; ?>
        <span class="chip"><?= icon('star', 'icon icon--sm') ?> <?= e($doctor['experience']) ?></span>
        <?php if ($doctor['languages']): ?><span class="chip"><?= e($doctor['languages']) ?></span><?php endif; ?>
      </div>
      <p style="color:rgba(255,255,255,.85);max-width:640px;"><?= e($doctor['intro']) ?></p>
      <div class="page-hero__ctas">
        <a href="<?= e(dm_url('appointment')) ?>?doctor=<?= e($slug) ?>" class="btn btn--accent"><?= icon('calendar', 'icon icon--sm') ?> Book Consultation</a>
        <a href="tel:<?= e(DM_PHONE) ?>" class="btn btn--ghost-light"><?= icon('phone', 'icon icon--sm') ?> <?= e(DM_PHONE_DISPLAY) ?></a>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="grid" style="grid-template-columns:1.6fr 1fr;align-items:start;">
      <div class="prose reveal">
        <h2 style="margin-top:0;">About <?= e($doctor['name']) ?></h2>
        <?php foreach ($doctor['bio'] as $p): ?><p><?= e($p) ?></p><?php endforeach; ?>

        <h3>Areas of clinical interest</h3>
        <ul>
          <?php foreach ($doctor['interests'] as $int): ?><li><?= e($int) ?></li><?php endforeach; ?>
        </ul>

        <?php if ($doctor['memberships'] || $doctor['awards']): ?>
        <h3>Memberships &amp; recognition</h3>
        <ul>
          <?php foreach (array_merge($doctor['memberships'], $doctor['awards']) as $m): ?><li><?= e($m) ?></li><?php endforeach; ?>
        </ul>
        <?php endif; ?>

        <h3>Consultation</h3>
        <p><?= e($doctor['timings']) ?></p>
      </div>

      <aside class="cta-panel reveal reveal-delay-1">
        <h3>Book with <?= e($doctor['name']) ?></h3>
        <p>Request a consultation — our team confirms your slot by phone.</p>
        <a href="<?= e(dm_url('appointment')) ?>?doctor=<?= e($slug) ?>" class="btn btn--accent"><?= icon('calendar', 'icon icon--sm') ?> Request Appointment</a>
        <a href="<?= e(DM_WHATSAPP) ?>" target="_blank" rel="noopener" class="btn btn--ghost-light"><?= icon('whatsapp', 'icon icon--sm') ?> WhatsApp Us</a>
        <p class="cta-panel__line">Vishrambag, Sangli–Miraj Road</p>
      </aside>
    </div>
  </div>
</section>

<section class="section section--soft">
  <div class="container" style="max-width:860px;">
    <div class="section__head section__head--center reveal">
      <span class="eyebrow" style="justify-content:center;">FAQs</span>
      <h2>Questions about consulting <?= e($doctor['name']) ?></h2>
    </div>
    <?php foreach ($doctor['faqs'] as $f): ?>
    <details class="faq-item reveal">
      <summary><?= e($f['q']) ?> <?= icon('chevron-down', 'icon icon--sm') ?></summary>
      <div class="faq-item__body"><?= e($f['a']) ?></div>
    </details>
    <?php endforeach; ?>
  </div>
</section>

<section class="section" style="padding-top:0;">
  <div class="container">
    <?php require __DIR__ . '/../includes/cta-strip.php'; ?>
  </div>
</section>
