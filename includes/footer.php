<?php
/**
 * Global footer + floating tools (WhatsApp, back-to-top, mobile bottom bar) + scripts.
 */
?>
</main>

<footer class="site-footer">
  <div class="container">
    <div class="footer__grid">
      <div class="footer__col footer__col--brand">
        <a href="<?= e(dm_url()) ?>" class="footer__logo" aria-label="Deccan Malti Hospital — Home">
          <img src="<?= e(dm_url('assets/img/logo-mark.webp')) ?>" alt="Deccan Malti Hospital logo" width="48" height="48">
          <span><strong>Deccan Malti</strong><small><b>Superspeciality</b> Hospital</small><em class="brand__tagline">Life Prevails</em></span>
        </a>
        <p class="footer__desc">Deccan Malti Hospital — Neuro, ICU &amp; Superspeciality Hospital in Vishrambag, Sangli.</p>
        <div class="footer__contact">
          <a href="tel:<?= e(DM_PHONE) ?>"><?= icon('phone', 'icon icon--sm') ?> <?= e(DM_PHONE_DISPLAY) ?></a>
          <a href="tel:<?= e(DM_LANDLINE) ?>"><?= icon('phone', 'icon icon--sm') ?> <?= e(DM_LANDLINE_DISPLAY) ?></a>
          <a href="<?= e(DM_MAPS_URL) ?>" target="_blank" rel="noopener"><?= icon('map-pin', 'icon icon--sm') ?> <?= e(DM_ADDRESS) ?></a>
        </div>
      </div>

      <div class="footer__col">
        <p class="footer__heading">Services &amp; Facilities</p>
        <ul>
          <?php foreach (array_slice(dm_services()['clinical']['groups']['Super Specialities'], 0, 5) as $service): ?>
          <li><a href="<?= e(dm_service_url($service)) ?>"><?= e($service['name']) ?></a></li>
          <?php endforeach; ?>
          <li><a href="<?= e(dm_url('departments')) ?>" class="footer__all">All services</a></li>
          <li><a href="<?= e(dm_url('facilities')) ?>">Facilities &amp; accommodation</a></li>
          <li><a href="<?= e(dm_url('gallery')) ?>">Hospital gallery</a></li>
        </ul>
      </div>

      <div class="footer__col">
        <p class="footer__heading">Patient Care</p>
        <ul>
          <li><a href="<?= e(dm_url('patient-care/appointment')) ?>">Appointment Guide</a></li>
          <li><a href="<?= e(dm_url('patient-care/admission-discharge')) ?>">Admission &amp; Discharge</a></li>
          <li><a href="<?= e(dm_url('patient-care/visitor-information')) ?>">Visitor Information</a></li>
          <li><a href="<?= e(dm_url('insurance#empanelment-help')) ?>">Insurance &amp; Empanelment Assistance</a></li>
          <li><a href="<?= e(dm_url('insurance#cmrf-help')) ?>">CMRF guidance</a></li>
          <li><a href="<?= e(dm_url('faqs')) ?>">FAQs</a></li>
        </ul>
      </div>

      <div class="footer__col">
        <p class="footer__heading">Stay Updated</p>
        <p class="footer__newsletter-desc">Health tips and hospital updates, once a month.</p>
        <form class="footer__newsletter" id="newsletterForm" data-action="<?= e(dm_url('api/newsletter.php')) ?>" novalidate>
          <?= csrf_field() ?>
          <label class="sr-only" for="nlEmail">Email address</label>
          <input type="email" id="nlEmail" name="email" placeholder="Your email address" required>
          <button type="submit" class="btn btn--accent btn--sm" aria-label="Subscribe"><?= icon('send', 'icon icon--sm') ?></button>
        </form>
        <p class="footer__form-msg" id="newsletterMsg" role="status"></p>
        <div class="footer__social">
          <?php if (DM_FACEBOOK): ?><a class="social-brand" href="<?= e(DM_FACEBOOK) ?>" target="_blank" rel="noopener" aria-label="Facebook (opens in a new tab)"><span class="social-brand-icon social-brand-icon--facebook"><?= dm_social_icon('facebook') ?></span></a><?php endif; ?>
          <?php if (DM_INSTAGRAM): ?><a class="social-brand" href="<?= e(DM_INSTAGRAM) ?>" target="_blank" rel="noopener" aria-label="Instagram (opens in a new tab)"><span class="social-brand-icon social-brand-icon--instagram"><?= dm_social_icon('instagram') ?></span></a><?php endif; ?>
          <?php if (DM_X): ?><a class="social-brand" href="<?= e(DM_X) ?>" target="_blank" rel="noopener" aria-label="X (opens in a new tab)"><span class="social-brand-icon social-brand-icon--x"><?= dm_social_icon('x') ?></span></a><?php endif; ?>
          <span class="social-brand social-brand--unavailable" title="Official YouTube channel URL not verified" aria-label="YouTube icon shown; official hospital channel link is not verified"><span class="social-brand-icon social-brand-icon--youtube"><?= dm_social_icon('youtube') ?></span></span>
          <a class="social-brand" href="<?= e(DM_WHATSAPP) ?>" target="_blank" rel="noopener" aria-label="WhatsApp (opens in a new tab)"><span class="social-brand-icon social-brand-icon--whatsapp"><?= dm_social_icon('whatsapp') ?></span></a>
        </div>
      </div>
    </div>

    <div class="footer__bottom">
      <p>&copy; <?= date('Y') ?> Deccan Malti Neuro &amp; Superspeciality Hospital, Sangli. All rights reserved.</p>
      <p class="footer__credit">Developed by <a href="https://digitaldots.in" target="_blank" rel="noopener">Digital Dots</a></p>
      <div class="footer__legal">
        <a href="<?= e(dm_url('privacy-policy')) ?>">Privacy Policy</a>
        <a href="<?= e(dm_url('terms-conditions')) ?>">Terms</a>
        <a href="<?= e(dm_url('medical-disclaimer')) ?>">Medical Disclaimer</a>
      </div>
    </div>
  </div>
  <div class="footer__accent-line"></div>
</footer>

<!-- Floating WhatsApp -->
<a href="<?= e(DM_WHATSAPP) ?>" class="float-whatsapp" target="_blank" rel="noopener" aria-label="Chat with us on WhatsApp">
  <?= icon('whatsapp', 'icon') ?>
</a>

<!-- Back to top -->
<button class="back-to-top" id="backToTop" aria-label="Back to top">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
</button>

<!-- Mobile sticky bottom bar -->
<div class="mobile-bar" id="mobileBar">
  <a href="tel:<?= e(DM_PHONE) ?>" class="mobile-bar__item">
    <?= icon('phone', 'icon') ?><span>Call</span>
  </a>
  <a href="<?= e(DM_WHATSAPP) ?>" target="_blank" rel="noopener" class="mobile-bar__item">
    <?= icon('whatsapp', 'icon') ?><span>WhatsApp</span>
  </a>
  <a href="<?= e(dm_url('appointment')) ?>" class="mobile-bar__item mobile-bar__item--booking">
    <?= icon('calendar', 'icon') ?><span>Book</span>
  </a>
</div>

<!-- Public-site language selector -->
<div class="language-switcher" id="languageSwitcher"
     data-dictionary-base="<?= e(dm_url('assets/i18n/')) ?>" data-no-translate>
  <button class="language-switcher__toggle" id="languageToggle" type="button"
          aria-label="Choose website language" aria-expanded="false" aria-controls="languageMenu">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
      <circle cx="12" cy="12" r="9"></circle>
      <path d="M3 12h18M12 3a15 15 0 0 1 0 18M12 3a15 15 0 0 0 0 18"></path>
    </svg>
    <span class="language-switcher__current" id="languageCurrent">EN</span>
  </button>
  <div class="language-switcher__menu" id="languageMenu" role="group"
       aria-label="Choose language" hidden>
    <p class="language-switcher__title">Website language</p>
    <button type="button" class="language-switcher__option" data-language="en" lang="en" aria-pressed="true">English</button>
    <button type="button" class="language-switcher__option" data-language="hi" lang="hi" aria-pressed="false">हिन्दी</button>
    <button type="button" class="language-switcher__option" data-language="mr" lang="mr" aria-pressed="false">मराठी</button>
  </div>
  <span class="sr-only" id="languageStatus" role="status" aria-live="polite"></span>
</div>

<!-- Vendor JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js" defer></script>

<!-- Main JS -->
<script src="<?= e(dm_url('assets/js/main.js')) ?>?v=1.0.9" defer></script>
<script src="<?= e(dm_url('assets/js/language-switcher.js')) ?>?v=1.0.0" defer></script>
</body>
</html>
