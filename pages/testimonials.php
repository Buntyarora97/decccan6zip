<?php
/** Testimonials — published only with written patient consent. */
require_once __DIR__ . '/../includes/breadcrumbs.php';
$testimonials = []; // [ADD TESTIMONIAL] only with written consent: ['name'=>'', 'service'=>'', 'date'=>'', 'text'=>'']
?>
<section class="page-hero">
  <div class="container">
    <?php dm_breadcrumbs(['Home' => '', 'Patient Stories' => null]); ?>
    <h1>Google Reviews</h1>
    <p class="lead" style="max-width:680px;">Read patients' original reviews on Google. We don't invent or edit review text.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <?php if ($testimonials): ?>
    <div class="grid grid--2">
      <?php foreach ($testimonials as $t): ?>
      <div class="testimonial-card reveal">
        <?= icon('quote', 'icon') ?>
        <blockquote>“<?= e($t['text']) ?>”</blockquote>
        <footer>
          <div><strong><?= e($t['name']) ?></strong><small><?= e($t['service']) ?> · <?= e($t['date']) ?></small></div>
        </footer>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <p class="lead" style="max-width:680px;margin:0 auto 20px;text-align:center;">The rating and review count below are from the Google listing screenshot you supplied. Select the card to open the complete, current reviews on Google.</p>
    <?php require __DIR__ . '/../includes/google-reviews-card.php'; ?>
    <?php endif; ?>
    <p class="google-review-note">Review text remains on Google so you can read the original wording and reviewer context.</p>
  </div>
</section>
