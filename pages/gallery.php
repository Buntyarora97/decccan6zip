<?php
/** Full-frame gallery from the new hospital photo shoot. */
require_once __DIR__ . '/../includes/breadcrumbs.php';
$items = [
    ['hospital-exterior.webp', 'exterior', 'Daytime exterior of Deccan Malti Hospital', 'Hospital exterior'],
    ['hospital-exterior-front.webp', 'exterior', 'Front-facing daytime view of the hospital building', 'Hospital exterior — front view'],
    ['hospital-exterior-approach.webp', 'exterior', 'Hospital building viewed from the entrance approach', 'Hospital entrance approach'],
    ['hospital-exterior-garden-view.webp', 'exterior', 'Hospital façade framed by trees', 'Hospital exterior — garden view'],
    ['hospital-side-view.webp', 'exterior', 'Hospital exterior from a side approach', 'Hospital exterior — side view'],
    ['emergency-entrance-signage.webp', 'emergency', 'Emergency entrance and visible hospital signage', 'Emergency entrance signage'],
    ['pharmacy-entrance.webp', 'support', 'Hospital pharmacy entrance with visible 24/7 signage', 'Pharmacy entrance'],
    ['hospital-interior-room.webp', 'interiors', 'Empty interior room with desk and chairs; exact room category is not identified', 'Hospital interior room'],
    ['hospital-interior-room-detail.webp', 'interiors', 'Empty room with furniture and a visible sink; exact room category is not identified', 'Hospital interior room — detail'],
    ['hospital-interior-room-angle.webp', 'interiors', 'Alternate view of an empty hospital interior room', 'Hospital interior — alternate view'],
    ['diagnostic-imaging-room.webp', 'diagnostics', 'Diagnostic imaging equipment; specific machine name is not identified', 'Diagnostic imaging space'],
    ['diagnostic-work-area.webp', 'diagnostics', 'Diagnostic work area; specific equipment is not identified', 'Diagnostic work area'],
    ['diagnostic-work-area-angle.webp', 'diagnostics', 'Alternate view of a diagnostic work area', 'Diagnostic work area — alternate view'],
    ['hospital-corridor.webp', 'interiors', 'Interior corridor at Deccan Malti Hospital', 'Hospital corridor'],
    ['hospital-emblem-display.webp', 'interiors', 'Deccan Malti Hospital emblem displayed on an interior wall', 'Hospital emblem display'],
    ['zoned-care-area.webp', 'interiors', 'Care area with red and yellow zone signs; room designation is not inferred', 'Care area with zoned signage'],
];
$filters = [
    'all' => 'All photos',
    'exterior' => 'Exterior',
    'emergency' => 'Emergency',
    'diagnostics' => 'Diagnostics',
    'support' => 'Support services',
    'interiors' => 'Interiors',
];
?>
<section class="page-hero">
  <div class="container">
    <?php dm_breadcrumbs(['Home' => '', 'Gallery' => null]); ?>
    <h1>Hospital Gallery</h1>
    <p class="lead" style="max-width:700px;">Recent photographs of the hospital exterior, signage, diagnostic work areas and interiors. Each photo is shown in its original landscape proportions.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="gallery-filters" role="group" aria-label="Filter hospital photographs">
      <?php foreach ($filters as $category => $label): ?>
      <button type="button" class="gallery-filter<?= $category === 'all' ? ' is-active' : '' ?>" data-gallery-filter="<?= e($category) ?>" aria-pressed="<?= $category === 'all' ? 'true' : 'false' ?>"><?= e($label) ?></button>
      <?php endforeach; ?>
    </div>
    <div class="gallery-grid" id="hospitalGallery">
      <?php foreach ($items as $i => [$filename, $category, $alt, $caption]): $src = 'assets/img/hospital-shoot/' . $filename; ?>
      <figure class="reveal" data-gallery-category="<?= e($category) ?>">
        <button type="button" class="gallery-open" data-gallery-open
                data-gallery-full="<?= e(dm_url($src)) ?>"
                data-gallery-alt="<?= e($alt) ?>"
                data-gallery-caption="<?= e($caption) ?>"
                aria-label="Open full image: <?= e($caption) ?>">
          <img src="<?= e(dm_url($src)) ?>" alt="<?= e($alt) ?>" width="1800" height="1200" loading="lazy" decoding="async">
          <span class="gallery-open__hint"><?= icon('expand', 'icon icon--sm') ?> View full image</span>
        </button>
        <figcaption><?= e($caption) ?></figcaption>
      </figure>
      <?php endforeach; ?>
    </div>
    <p class="gallery__note">Photographs show the complete frame. Some rooms and equipment are captioned neutrally where their exact type cannot be verified from the image.</p>
  </div>
</section>

<dialog class="gallery-lightbox" id="galleryLightbox" aria-labelledby="galleryLightboxCaption">
  <div class="gallery-lightbox__inner">
    <div class="gallery-lightbox__toolbar">
      <span class="gallery-lightbox__position" id="galleryLightboxPosition"></span>
      <button type="button" class="gallery-lightbox__close" data-gallery-close aria-label="Close full-size image"><?= icon('close', 'icon') ?></button>
    </div>
    <div class="gallery-lightbox__stage">
      <button type="button" class="gallery-lightbox__nav" data-gallery-prev aria-label="Previous photo"><?= icon('chevron-left', 'icon') ?></button>
      <img id="galleryLightboxImage" src="" alt="">
      <button type="button" class="gallery-lightbox__nav" data-gallery-next aria-label="Next photo"><?= icon('chevron-right', 'icon') ?></button>
    </div>
    <p id="galleryLightboxCaption" class="gallery-lightbox__caption"></p>
  </div>
</dialog>
