<?php
/** Link to the hospital's Google listing; individual Google review text stays on Google. */
$dmGoogleReviewsUrl = 'https://share.google/IZETQeGodoO0wkvUh';
?>
<a class="google-review-card reveal" href="<?= e($dmGoogleReviewsUrl) ?>" target="_blank" rel="noopener noreferrer" aria-label="Open Deccan Malti Hospital's Google reviews in a new tab">
  <img class="google-review-card__logo" src="<?= e(dm_url('assets/img/google-g.png')) ?>" alt="" width="48" height="48" loading="lazy" decoding="async">
  <span class="google-review-card__content">
    <span class="google-review-card__label">Google Reviews</span>
    <strong class="google-review-card__rating" aria-label="4.9 out of 5 stars">4.9 <span class="google-review-card__stars" aria-hidden="true">★★★★★</span></strong>
    <small>431 reviews · Read the full, original reviews on Google</small>
  </span>
  <span class="google-review-card__action">View reviews <?= icon('arrow-right', 'icon icon--sm') ?></span>
</a>