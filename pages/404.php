<?php
/** Custom 404 */
http_response_code(404);
$depts = dm_department_index();
?>
<section class="page-hero" style="text-align:center;">
  <div class="container">
    <p style="font-family:var(--font-head);font-size:clamp(70px,10vw,120px);font-weight:800;color:var(--yellow);line-height:1;">404</p>
    <h1 style="margin-top:8px;">This page seems to have wandered off</h1>
    <p class="lead" style="margin:0 auto;max-width:560px;">The page you're looking for doesn't exist or has moved. Let's get you back on track.</p>
    <div class="page-hero__ctas" style="justify-content:center;">
      <a href="<?= e(dm_url()) ?>" class="btn btn--accent">Go to Homepage</a>
      <a href="tel:<?= e(DM_PHONE) ?>" class="btn btn--ghost-light"><?= icon('phone', 'icon icon--sm') ?> <?= e(DM_PHONE_DISPLAY) ?></a>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section__head section__head--center">
      <h2 style="font-size:26px;">Looking for a department?</h2>
    </div>
    <div class="grid grid--4">
      <?php foreach ($depts as $slug => $d): ?>
      <a href="<?= e(dm_url('departments/' . $slug)) ?>" class="chip" style="justify-content:center;padding:14px;"><?= icon($d['icon'], 'icon icon--sm') ?> <?= e($d['name']) ?></a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
