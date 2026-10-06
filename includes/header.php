<?php
/**
 * Global header — top utility bar + main nav + accessible mega menus.
 */
$currentPath = dm_path();
$doctorsList = dm_doctors();
$serviceCatalog = dm_services();
$navItems = dm_nav();
$servicePreviewPhoto = static function (string $serviceId): array {
    $photos = [
        'neurosurgery' => ['assets/img/real/dr-rohan-patil.webp', 'Dr. Rohan Patil, neurosurgeon at Deccan Malti Hospital'],
        'neurology' => ['assets/img/neuro-centre-background.jpg', 'Neuro centre at Deccan Malti Hospital'],
        'general-surgery' => ['assets/img/real/dr-p-c-patil.webp', 'Dr. P. C. Patil, general surgeon at Deccan Malti Hospital'],
        'radiology' => ['assets/img/hospital-shoot/diagnostic-imaging-room.webp', 'Diagnostic imaging room at Deccan Malti Hospital'],
        'ct-scan' => ['assets/img/hospital-shoot/diagnostic-work-area-angle.webp', 'Diagnostic work area at Deccan Malti Hospital'],
        'digital-x-ray' => ['assets/img/hospital-shoot/diagnostic-imaging-room.webp', 'Diagnostic imaging room at Deccan Malti Hospital'],
        'eeg' => ['assets/img/hospital-shoot/diagnostic-work-area.webp', 'Diagnostic work area at Deccan Malti Hospital'],
        'ncv' => ['assets/img/hospital-shoot/diagnostic-work-area-angle.webp', 'Diagnostic work area at Deccan Malti Hospital'],
        'pathology-laboratory' => ['assets/img/hospital-shoot/diagnostic-work-area.webp', 'Diagnostic work area at Deccan Malti Hospital'],
        'pharmacy' => ['assets/img/hospital-shoot/pharmacy-entrance.webp', 'Hospital pharmacy entrance'],
        'physiotherapy-rehabilitation' => ['assets/img/hospital-shoot/zoned-care-area.webp', 'Care area at Deccan Malti Hospital'],
        'ambulance-service' => ['assets/img/hospital-shoot/emergency-entrance-signage.webp', 'Hospital emergency entrance'],
    ];
    return $photos[$serviceId] ?? ['assets/img/real/hospital-reception-lobby.webp', 'Interior of Deccan Malti Hospital'];
};
$firstService = $serviceCatalog['clinical']['groups']['Super Specialities'][0]
    ?? reset($serviceCatalog)['groups']['Diagnostic Services'][0]
    ?? null;
$firstServicePhoto = $firstService ? $servicePreviewPhoto($firstService['id']) : [
    'assets/img/hospital-shoot/hospital-exterior-front.webp',
    'Deccan Malti Hospital exterior',
];

function nav_active(string $url, string $current): string
{
    if ($url === '') return $current === '' ? ' is-active' : '';
    return ($current === $url || str_starts_with($current, $url . '/')) ? ' is-active' : '';
}
?>
<header class="site-header" id="site-header">
  <!-- 1. Slim top utility bar -->
  <div class="topbar">
    <div class="container topbar__inner">
      <a class="topbar__item" href="<?= e(DM_MAPS_URL) ?>" target="_blank" rel="noopener">
        <?= icon('map-pin', 'icon icon--sm') ?>
        <span class="topbar__text">Vishrambag, Sangli–Miraj Road, Sangli 416415</span>
      </a>
      <div class="topbar__right">
        <a class="topbar__item" href="tel:<?= e(DM_LANDLINE) ?>"><?= icon('phone', 'icon icon--sm') ?><span><?= e(DM_LANDLINE_DISPLAY) ?></span></a>
        <a class="topbar__item" href="tel:<?= e(DM_PHONE) ?>"><?= icon('phone', 'icon icon--sm') ?><span><?= e(DM_PHONE_DISPLAY) ?></span></a>
        <div class="topbar__social">
          <?php if (DM_FACEBOOK): ?><a class="social-brand" href="<?= e(DM_FACEBOOK) ?>" target="_blank" rel="noopener" aria-label="Facebook (opens in a new tab)"><span class="social-brand-icon social-brand-icon--facebook"><?= dm_social_icon('facebook') ?></span></a><?php endif; ?>
          <?php if (DM_INSTAGRAM): ?><a class="social-brand" href="<?= e(DM_INSTAGRAM) ?>" target="_blank" rel="noopener" aria-label="Instagram (opens in a new tab)"><span class="social-brand-icon social-brand-icon--instagram"><?= dm_social_icon('instagram') ?></span></a><?php endif; ?>
          <?php if (DM_X): ?><a class="social-brand" href="<?= e(DM_X) ?>" target="_blank" rel="noopener" aria-label="X (opens in a new tab)"><span class="social-brand-icon social-brand-icon--x"><?= dm_social_icon('x') ?></span></a><?php endif; ?>
          <span class="social-brand social-brand--unavailable" title="Official YouTube channel URL not verified" aria-label="YouTube icon shown; official hospital channel link is not verified"><span class="social-brand-icon social-brand-icon--youtube"><?= dm_social_icon('youtube') ?></span></span>
          <a class="social-brand" href="<?= e(DM_WHATSAPP) ?>" target="_blank" rel="noopener" aria-label="WhatsApp (opens in a new tab)"><span class="social-brand-icon social-brand-icon--whatsapp"><?= dm_social_icon('whatsapp') ?></span></a>
        </div>
      </div>
    </div>
  </div>

  <!-- 2. Main navigation -->
  <div class="mainnav">
    <div class="container mainnav__inner">
      <a class="brand" href="<?= e(dm_url()) ?>" aria-label="<?= e(SITE_NAME) ?> — Home">
        <img src="<?= e(dm_url('assets/img/logo-mark.webp')) ?>" alt="Deccan Malti Hospital logo" width="52" height="52" class="brand__logo">
        <span class="brand__text">
          <strong>Deccan Malti</strong>
          <small><b>Superspeciality</b> Hospital</small>
          <em class="brand__tagline">Life Prevails</em>
        </span>
      </a>

      <nav class="desktop-nav" aria-label="Primary">
        <ul class="desktop-nav__list">
          <?php foreach ($navItems as $item): ?>
          <li class="desktop-nav__item<?= isset($item['mega']) ? ' has-mega' : '' ?>">
            <a href="<?= e(dm_url($item['url'])) ?>" class="desktop-nav__link<?= nav_active($item['url'], $currentPath) ?>"
               <?php if (isset($item['mega'])): ?>aria-haspopup="true" aria-expanded="false" data-mega-trigger="<?= e($item['mega']) ?>"<?php endif; ?>>
              <?= e($item['label']) ?>
              <?= isset($item['mega']) ? icon('chevron-down', 'icon icon--xs nav-caret') : '' ?>
            </a>
          </li>
          <?php endforeach; ?>
        </ul>
      </nav>

      <div class="mainnav__actions">
        <a href="tel:<?= e(DM_PHONE) ?>" class="call-chip" aria-label="Call the hospital">
          <?= icon('phone', 'icon') ?>
        </a>
        <a href="<?= e(dm_url('appointment')) ?>" class="btn btn--booking btn--sm">
          <?= icon('calendar', 'icon icon--sm') ?><span>Book Appointment</span>
        </a>
        <button class="menu-toggle" id="menuToggle" aria-label="Open menu" aria-expanded="false" aria-controls="mobileDrawer">
          <?= icon('menu', 'icon') ?>
        </button>
      </div>
    </div>
  </div>

  <!-- Mega menus (desktop) -->
  <div class="mega-wrap" id="megaWrap" hidden>
    <!-- About mega menu -->
    <div class="mega mega--small mega--about" data-mega="about" role="region" aria-label="About Deccan Malti menu">
      <div class="container mega__grid mega__grid--image">
        <div class="mega__col mega__col--links">
          <p class="mega__heading">About Deccan Malti</p>
          <ul class="mega__list mega__list--single">
            <li><a href="<?= e(dm_url('about')) ?>" class="mega__dept-link"><?= icon('info', 'icon icon--sm') ?><span>Hospital story</span></a></li>
            <li><a href="<?= e(dm_url('leadership')) ?>" class="mega__dept-link"><?= icon('users', 'icon icon--sm') ?><span>Founders &amp; leadership</span></a></li>
            <li><a href="<?= e(dm_url('facilities')) ?>" class="mega__dept-link"><?= icon('building', 'icon icon--sm') ?><span>Facilities</span></a></li>
            <li><a href="<?= e(dm_url('gallery')) ?>" class="mega__dept-link"><?= icon('image', 'icon icon--sm') ?><span>Hospital gallery</span></a></li>
          </ul>
        </div>
        <div class="mega__col mega__col--support">
          <p class="mega__heading">Information &amp; Support</p>
          <ul class="mega__quick">
            <li><a href="<?= e(dm_url('insurance#empanelment-help')) ?>"><?= icon('shield', 'icon icon--sm') ?> Insurance &amp; empanelment assistance</a></li>
            <li><a href="<?= e(dm_url('health-library')) ?>"><?= icon('file', 'icon icon--sm') ?> Blog</a></li>
            <li><a href="<?= e(dm_url('about')) ?>#infrastructure"><?= icon('flask', 'icon icon--sm') ?> Hospital infrastructure</a></li>
            <li><a href="<?= e(dm_brochure_url()) ?>" download="Deccan-Malti-Hospital-Guide.pdf"><?= icon('download', 'icon icon--sm') ?> Download hospital guide (PDF)</a></li>
          </ul>
        </div>
        <a class="mega-feature" href="<?= e(dm_url('about')) ?>" aria-label="Explore Deccan Malti Hospital">
          <img src="<?= e(dm_url('assets/img/hospital-shoot/hospital-exterior-garden-view.webp')) ?>" alt="Deccan Malti Hospital exterior and garden">
          <span class="mega-feature__shade"></span>
          <span class="mega-feature__copy"><small>DECCAN MALTI · SANGLI</small><strong>Care close to home</strong><span>Explore our hospital <span aria-hidden="true">→</span></span></span>
        </a>
      </div>
    </div>

    <!-- Compact services menu with live image preview -->
    <div class="mega mega--services" data-mega="services" role="region" aria-label="Services menu">
      <div class="mega__services-head">
        <div class="mega__services-title">
          <span class="mega__eyebrow">Care at Deccan Malti</span>
          <p class="mega__heading">Explore our services</p>
          <span class="mega__subheading">Clinical, diagnostic, allied and supportive care</span>
        </div>
        <a class="mega__view-all" href="<?= e(dm_url('departments')) ?>">View full service guide <?= icon('arrow-right', 'icon icon--xs') ?></a>
      </div>
      <div class="mega__services-body">
        <div class="mega__services-grid">
          <?php foreach ($serviceCatalog as $categoryKey => $category): ?>
          <section class="mega__service-group mega__service-group--<?= e($categoryKey) ?>" aria-label="<?= e($category['label']) ?>">
            <h2><?= icon($category['icon'], 'icon icon--sm') ?> <?= e($category['label']) ?></h2>
            <?php foreach ($category['groups'] as $groupName => $items): ?>
            <div class="mega__service-subgroup">
              <?php if ($categoryKey === 'clinical'): ?><h3><?= e($groupName) ?></h3><?php endif; ?>
              <ul class="mega__service-list">
                <?php foreach ($items as $service):
                  $photo = $servicePreviewPhoto($service['id']);
                  $isFirstService = $firstService && $firstService['id'] === $service['id'];
                ?>
                <li>
                  <a href="<?= e(dm_service_url($service)) ?>"
                     class="mega__service-link<?= $isFirstService ? ' is-active' : '' ?>"
                     data-service-preview
                     data-preview-image="<?= e(dm_url($photo[0])) ?>"
                     data-preview-alt="<?= e($photo[1]) ?>"
                     data-preview-title="<?= e($service['name']) ?>"
                     data-preview-summary="<?= e($service['summary']) ?>"
                     data-preview-url="<?= e(dm_service_url($service)) ?>">
                    <?= icon($service['icon'], 'icon icon--sm') ?><span><?= e($service['name']) ?></span>
                  </a>
                </li>
                <?php endforeach; ?>
              </ul>
            </div>
            <?php endforeach; ?>
          </section>
          <?php endforeach; ?>
        </div>
        <a class="mega-preview" id="megaServicePreview"
           href="<?= e($firstService ? dm_service_url($firstService) : dm_url('departments')) ?>">
          <span class="mega-preview__imgwrap">
            <img id="megaServicePreviewImg" src="<?= e(dm_url($firstServicePhoto[0])) ?>" alt="<?= e($firstServicePhoto[1]) ?>" width="520" height="360">
            <span class="mega-preview__badge">OUR SERVICES</span>
          </span>
          <span class="mega-preview__body">
            <strong id="megaServicePreviewTitle"><?= e($firstService['name'] ?? 'Hospital services') ?></strong>
            <span id="megaServicePreviewSummary"><?= e($firstService['summary'] ?? 'Explore the services available at Deccan Malti Hospital.') ?></span>
            <span class="mega-preview__cta">Explore service <?= icon('arrow-right', 'icon icon--xs') ?></span>
          </span>
        </a>
      </div>
    </div>

    <!-- Doctors mega menu -->
    <div class="mega mega--small mega--doctors" data-mega="doctors" role="region" aria-label="Doctors menu">
      <div class="container mega__grid mega__grid--image">
        <div class="mega__col mega__col--links">
          <p class="mega__heading">Our Specialists</p>
          <ul class="mega__doctor-list">
            <?php foreach ($doctorsList as $slug => $doc): if (!empty($doc['published'])): ?>
            <li><a href="<?= e(dm_url('doctors/' . $slug)) ?>" class="mega__doctor-link">
              <img src="<?= e(dm_url($doc['image'])) ?>" alt="" width="48" height="48">
              <span><strong><?= e($doc['name']) ?></strong><small><?= e($doc['speciality']) ?></small></span><?= icon('arrow-right', 'icon icon--xs') ?>
            </a></li>
            <?php endif; endforeach; ?>
          </ul>
          <a class="mega__text-link" href="<?= e(dm_url('doctors')) ?>">View all doctors <?= icon('arrow-right', 'icon icon--xs') ?></a>
        </div>
        <div class="mega__col mega__col--support">
          <p class="mega__heading">Quick Actions</p>
          <ul class="mega__quick">
            <li><a href="<?= e(dm_url('appointment')) ?>"><?= icon('calendar', 'icon icon--sm') ?> Book an Appointment</a></li>
            <li><a href="<?= e(dm_url('health-library')) ?>"><?= icon('file', 'icon icon--sm') ?> Health library</a></li>
          </ul>
        </div>
        <a class="mega-feature mega-feature--doctor" href="<?= e(dm_url('doctors')) ?>" aria-label="Meet our specialists">
          <img src="<?= e(dm_url('assets/img/real/hospital-reception-team.webp')) ?>" alt="Deccan Malti Hospital reception team">
          <span class="mega-feature__shade"></span>
          <span class="mega-feature__copy"><small>OUR SPECIALISTS</small><strong>Meet your care team</strong><span>View doctor profiles <span aria-hidden="true">→</span></span></span>
        </a>
      </div>
    </div>

    <!-- Patient Care mega menu -->
    <div class="mega mega--small mega--patient" data-mega="patient" role="region" aria-label="Patient care menu">
      <div class="container mega__grid mega__grid--image">
        <div class="mega__col mega__col--links">
          <p class="mega__heading">Patient Information</p>
          <ul class="mega__list">
            <?php foreach (dm_patient_care_pages() as $slug => $label): ?>
            <li><a href="<?= e(dm_url('patient-care/' . $slug)) ?>" class="mega__dept-link"><?= icon('document-check', 'icon icon--sm') ?><span><?= e($label) ?></span></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="mega__col mega__col--support">
          <p class="mega__heading">Help &amp; Support</p>
          <ul class="mega__quick">
            <li><a href="<?= e(dm_url('insurance#empanelment-help')) ?>"><?= icon('shield', 'icon icon--sm') ?> Insurance &amp; Empanelment Assistance</a></li>
            <li><a href="<?= e(dm_url('faqs')) ?>"><?= icon('info', 'icon icon--sm') ?> FAQs</a></li>
            <li><a href="<?= e(dm_url('contact')) ?>"><?= icon('mail', 'icon icon--sm') ?> Contact Us</a></li>
          </ul>
        </div>
        <a class="mega-feature mega-feature--patient" href="<?= e(dm_url('patient-care')) ?>" aria-label="Read the patient care guide">
          <img src="<?= e(dm_url('assets/img/real/hospital-patient-room.webp')) ?>" alt="Patient room at Deccan Malti Hospital">
          <span class="mega-feature__shade"></span>
          <span class="mega-feature__copy"><small>PLAN YOUR VISIT</small><strong>Patient care guide</strong><span>See visit information <span aria-hidden="true">→</span></span></span>
        </a>
      </div>
    </div>
  </div>
</header>

<!-- 3. Mobile drawer -->
  <div class="drawer" id="mobileDrawer" aria-hidden="true">
  <div class="drawer__backdrop" data-drawer-close></div>
  <div class="drawer__panel" role="dialog" aria-modal="true" aria-label="Hospital navigation menu">
    <div class="drawer__head">
      <img src="<?= e(dm_url('assets/img/logo-mark.webp')) ?>" alt="Deccan Malti Hospital logo" width="40" height="40">
      <button class="drawer__close" data-drawer-close aria-label="Close menu"><?= icon('close', 'icon') ?></button>
    </div>
    <nav class="drawer__nav" aria-label="Mobile">
      <a href="<?= e(dm_url()) ?>" class="drawer__link">Home</a>
      <details class="drawer__group">
        <summary>About <?= icon('chevron-down', 'icon icon--sm') ?></summary>
        <div class="drawer__sub">
          <a href="<?= e(dm_url('about')) ?>">Hospital story</a>
          <a href="<?= e(dm_url('leadership')) ?>">Founders &amp; leadership</a>
          <a href="<?= e(dm_url('facilities')) ?>">Facilities</a>
          <a href="<?= e(dm_url('gallery')) ?>">Hospital gallery</a>
          <a href="<?= e(dm_url('insurance#empanelment-help')) ?>">Insurance &amp; empanelment support</a>
          <a href="<?= e(dm_brochure_url()) ?>" download="Deccan-Malti-Hospital-Guide.pdf">Download hospital guide (PDF)</a>
          <a class="drawer__about-image" href="<?= e(dm_url('about')) ?>">
            <img src="<?= e(dm_url('assets/img/hospital-shoot/hospital-exterior-garden-view.webp')) ?>" alt="Deccan Malti Hospital exterior">
            <span>Explore our hospital <span aria-hidden="true">→</span></span>
          </a>
        </div>
      </details>
      <details class="drawer__group">
        <summary>Services <?= icon('chevron-down', 'icon icon--sm') ?></summary>
        <div class="drawer__sub drawer__sub--catalog">
          <?php foreach ($serviceCatalog as $categoryKey => $category): ?>
          <div class="drawer__category">
            <?php
              $groupNames = array_keys($category['groups']);
              $categoryHeadingMatchesGroup = count($groupNames) === 1 && $groupNames[0] === $category['label'];
            ?>
            <?php if (!$categoryHeadingMatchesGroup): ?>
            <strong><?= e($category['label']) ?></strong>
            <?php endif; ?>
            <?php foreach ($category['groups'] as $groupName => $items): ?>
            <details class="drawer__subgroup">
              <summary><?= e($groupName) ?></summary>
              <div class="drawer__subgroup-links">
                <?php foreach ($items as $service): ?>
                <a href="<?= e(dm_service_url($service)) ?>"><?= e($service['name']) ?></a>
                <?php endforeach; ?>
              </div>
            </details>
            <?php endforeach; ?>
          </div>
          <?php endforeach; ?>
          <a href="<?= e(dm_url('departments')) ?>" class="drawer__all">View full service guide</a>
        </div>
      </details>
      <details class="drawer__group">
        <summary>Doctors <?= icon('chevron-down', 'icon icon--sm') ?></summary>
        <div class="drawer__sub">
          <?php foreach ($doctorsList as $slug => $doc): if (!empty($doc['published'])): ?>
          <a href="<?= e(dm_url('doctors/' . $slug)) ?>"><?= e($doc['name']) ?></a>
          <?php endif; endforeach; ?>
          <a href="<?= e(dm_url('doctors')) ?>" class="drawer__all">Find a Doctor</a>
        </div>
      </details>
      <details class="drawer__group">
        <summary>Patient Care <?= icon('chevron-down', 'icon icon--sm') ?></summary>
        <div class="drawer__sub">
          <?php foreach (dm_patient_care_pages() as $slug => $label): ?>
          <a href="<?= e(dm_url('patient-care/' . $slug)) ?>"><?= e($label) ?></a>
          <?php endforeach; ?>
        </div>
      </details>
      <a href="<?= e(dm_url('facilities')) ?>" class="drawer__link">Facilities</a>
      <a href="<?= e(dm_url('gallery')) ?>" class="drawer__link">Gallery</a>
      <a href="<?= e(dm_url('health-library')) ?>" class="drawer__link">Blog</a>
      <a href="<?= e(dm_url('contact')) ?>" class="drawer__link">Contact</a>
    </nav>
    <div class="drawer__cta">
      <a href="<?= e(dm_url('appointment')) ?>" class="btn btn--booking btn--block">Book Appointment</a>
      <a href="tel:<?= e(DM_PHONE) ?>" class="btn btn--outline btn--block"><?= icon('phone', 'icon icon--sm') ?> <?= e(DM_PHONE_DISPLAY) ?></a>
    </div>
  </div>
</div>

<main id="main-content">
