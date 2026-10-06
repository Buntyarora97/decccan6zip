<?php
/** Leadership page */
require_once __DIR__ . '/../includes/breadcrumbs.php';
$doctors = dm_doctors();
?>
<section class="page-hero">
  <div class="container">
    <?php dm_breadcrumbs(['Home' => '', 'Leadership' => null]); ?>
    <h1>Leadership</h1>
    <p class="lead" style="max-width:700px;">Deccan Malti is led by its founders — clinicians who consult patients every day, not administrators behind a desk.</p>
  </div>
</section>

<section class="section">
  <div class="container" style="max-width:900px;">
    <?php $i = 0; foreach ($doctors as $slug => $doc): if (empty($doc['published'])) continue; ?>
    <div class="card reveal" style="display:grid;grid-template-columns:200px 1fr;gap:var(--sp-4);margin-bottom:var(--sp-4);align-items:start;">
      <img src="<?= e(dm_url($doc['image'])) ?>" alt="<?= e($doc['name']) ?>, <?= e($doc['role']) ?>" width="200" height="240" style="border-radius:var(--r-md);object-fit:cover;width:100%;" loading="lazy">
      <div>
        <span class="doctor-card__spec"><?= e($doc['role']) ?></span>
        <h2 style="font-size:26px;margin:6px 0 4px;"><?= e($doc['name']) ?></h2>
        <p class="doctor-card__quals" style="margin-bottom:12px;"><?= e(implode(', ', $doc['qualifications'])) ?> · <?= e($doc['experience']) ?></p>
        <p style="color:var(--text-soft);font-size:15px;"><?= e($doc['bio'][1] ?? $doc['intro']) ?></p>
        <div style="display:flex;gap:10px;margin-top:16px;flex-wrap:wrap;">
          <a href="<?= e(dm_url('doctors/' . $slug)) ?>" class="btn btn--outline btn--sm">Full Profile</a>
          <a href="<?= e(dm_url('appointment')) ?>?doctor=<?= e($slug) ?>" class="btn btn--primary btn--sm">Book Consultation</a>
        </div>
      </div>
    </div>
    <?php $i++; endforeach; ?>
    <div style="margin-top:var(--sp-4);"><?php require __DIR__ . '/../includes/cta-strip.php'; ?></div>
  </div>
</section>
