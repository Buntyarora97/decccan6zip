<?php
/** Health Library — article listing */
require_once __DIR__ . '/../includes/breadcrumbs.php';
$articles = dm_articles();
?>
<section class="page-hero">
  <div class="container">
    <?php dm_breadcrumbs(['Home' => '', 'Blog' => null]); ?>
    <h1>Blog &amp; Health Library</h1>
    <p class="lead" style="max-width:700px;">Practical health guides for patients and families. Read for general education, not self-diagnosis.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="grid grid--3">
      <?php $i=0; foreach ($articles as $slug => $a): ?>
      <a href="<?= e(dm_url('health-library/' . $slug)) ?>" class="dept-card article-listing-card reveal<?= $i%3 ? ' reveal-delay-'.($i%3) : '' ?>">
        <div class="article-listing-card__icon" aria-hidden="true"><?= icon('document-check', 'icon') ?></div>
        <div class="dept-card__body" style="padding-top:24px;">
          <span class="article-card__cat"><?= e($a['category']) ?></span>
          <h3 style="margin-top:6px;"><?= e($a['title']) ?></h3>
          <p><?= e($a['excerpt']) ?></p>
          <p class="article-card__meta">Reviewed <?= e(date('M Y', strtotime($a['updated']))) ?> · <?= e($a['readtime']) ?></p>
        </div>
      </a>
      <?php $i++; endforeach; ?>
    </div>
  </div>
</section>
