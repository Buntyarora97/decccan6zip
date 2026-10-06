<?php
/** Single article — vars: $article, $slug */
require_once __DIR__ . '/../includes/breadcrumbs.php';
echo dm_schema_article($article, $seo['desc'] ?? null);
?>
<section class="page-hero">
  <div class="container" style="max-width:820px;">
    <?php dm_breadcrumbs(['Home' => '', 'Blog' => 'health-library', $article['title'] => null]); ?>
    <span class="chip" style="background:rgba(25,156,60,.14);color:#7FE0A8;border-color:rgba(25,156,60,.32);margin-bottom:14px;"><?= e($article['category']) ?></span>
    <h1 style="font-size:clamp(26px,3.2vw,40px);"><?= e($article['title']) ?></h1>
    <p style="color:rgba(255,255,255,.75);font-size:14px;margin-top:10px;">
      By <?= e($article['author']) ?> · Published <?= e(date('j M Y', strtotime($article['published']))) ?> · Updated <?= e(date('j M Y', strtotime($article['updated']))) ?> · <?= e($article['readtime']) ?>
    </p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="grid" style="grid-template-columns:1.7fr 1fr;align-items:start;">
      <article class="prose reveal">
        <?php foreach ($article['body'] as $block): ?>
        <h2 style="font-size:24px;"><?= e($block['h']) ?></h2>
        <p><?= e($block['p']) ?></p>
        <?php endforeach; ?>

        <div class="content-disclaimer">
          <?= icon('info', 'icon') ?>
          <div>
            <strong>Medical disclaimer.</strong> This article is for general education only and is not a substitute for professional medical advice, diagnosis or treatment. Always consult a qualified doctor about your specific condition.
            Last updated <?= e(date('F Y', strtotime($article['updated']))) ?>.
          </div>
        </div>
      </article>

      <aside class="cta-panel reveal reveal-delay-1">
        <h3>Concerned about a symptom?</h3>
        <p>Articles inform — doctors diagnose. Book a consultation for advice specific to you.</p>
        <a href="<?= e(dm_url('appointment')) ?>" class="btn btn--accent"><?= icon('calendar', 'icon icon--sm') ?> Book Appointment</a>
        <a href="tel:<?= e(DM_PHONE) ?>" class="btn btn--ghost-light"><?= icon('phone', 'icon icon--sm') ?> <?= e(DM_PHONE_DISPLAY) ?></a>
      </aside>
    </div>
  </div>
</section>
