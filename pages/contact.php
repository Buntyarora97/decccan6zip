<?php
/** Contact page */
require_once __DIR__ . '/../includes/breadcrumbs.php';
$depts = dm_departments();
?>
<section class="page-hero">
  <div class="container">
    <?php dm_breadcrumbs(['Home' => '', 'Contact' => null]); ?>
    <h1>Contact Us</h1>
    <p class="lead" style="max-width:680px;">Questions, appointments or directions — we're easy to reach.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="grid" style="grid-template-columns:1fr 1.4fr;align-items:start;">
      <div style="display:flex;flex-direction:column;gap:16px;">
        <div class="card reveal">
          <h3 style="margin-bottom:16px;">Reach us</h3>
          <div style="display:flex;flex-direction:column;gap:14px;">
            <a href="tel:<?= e(DM_PHONE) ?>" style="display:flex;gap:12px;align-items:flex-start;color:var(--text);"><span style="color:var(--teal);"><?= icon('phone', 'icon') ?></span><span><strong style="font-family:var(--font-head);color:var(--navy);display:block;">Appointments &amp; Mobile</strong><?= e(DM_PHONE_DISPLAY) ?></span></a>
            <a href="tel:<?= e(DM_LANDLINE) ?>" style="display:flex;gap:12px;align-items:flex-start;color:var(--text);"><span style="color:var(--teal);"><?= icon('phone', 'icon') ?></span><span><strong style="font-family:var(--font-head);color:var(--navy);display:block;">Landline</strong><?= e(DM_LANDLINE_DISPLAY) ?></span></a>
            <a href="<?= e(DM_WHATSAPP) ?>" target="_blank" rel="noopener" style="display:flex;gap:12px;align-items:flex-start;color:var(--text);"><span style="color:var(--teal);"><?= icon('whatsapp', 'icon') ?></span><span><strong style="font-family:var(--font-head);color:var(--navy);display:block;">WhatsApp</strong><?= e(DM_PHONE_DISPLAY) ?></span></a>
            <a href="<?= e(DM_MAPS_URL) ?>" target="_blank" rel="noopener" style="display:flex;gap:12px;align-items:flex-start;color:var(--text);"><span style="color:var(--teal);"><?= icon('map-pin', 'icon') ?></span><span><strong style="font-family:var(--font-head);color:var(--navy);display:block;">Address</strong><?= e(DM_ADDRESS) ?></span></a>
          </div>
        </div>
        <div class="emergency-note reveal">
          <?= icon('alert', 'icon') ?>
          <span>For life-threatening emergencies, call local emergency services or go to the nearest emergency facility immediately.</span>
        </div>
        <div class="map-embed reveal">
          <!-- [VERIFY] Replace with the hospital's exact Google Maps embed code -->
          <iframe src="https://www.google.com/maps?q=<?= rawurlencode('Deccan Malti Neuro & Superspeciality Hospital, Vishrambag, Sangli, Maharashtra 416415') ?>&output=embed" title="Map — Deccan Malti Hospital, Vishrambag, Sangli" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>

      <form class="form-card reveal reveal-delay-1" method="post" action="<?= e(dm_url('api/contact.php')) ?>" data-ajax data-status-target="contactStatus" novalidate>
        <?= csrf_field() ?>
        <div class="form-honeypot" aria-hidden="true">
          <label>Leave this field empty <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
        </div>
        <h3 style="margin-bottom:20px;">Send an enquiry</h3>
        <div class="form-grid">
          <div class="form-field">
            <label for="cName">Your Name <span class="req">*</span></label>
            <input type="text" id="cName" name="name" required maxlength="120" autocomplete="name">
            <span class="error-msg">Please enter your name.</span>
          </div>
          <div class="form-field">
            <label for="cPhone">Phone</label>
            <input type="tel" id="cPhone" name="phone" maxlength="15" inputmode="tel" autocomplete="tel">
          </div>
          <div class="form-field">
            <label for="cEmail">Email</label>
            <input type="email" id="cEmail" name="email" maxlength="190" autocomplete="email">
            <span class="error-msg">Please enter a valid email.</span>
          </div>
          <div class="form-field">
            <label for="cDept">Related Department</label>
            <select id="cDept" name="department">
              <option value="">General enquiry</option>
              <?php foreach ($depts as $slug => $d): ?>
              <option value="<?= e($d['name']) ?>"><?= e($d['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-field form-field--full">
            <label for="cSubject">Subject</label>
            <input type="text" id="cSubject" name="subject" maxlength="160">
          </div>
          <div class="form-field form-field--full">
            <label for="cMsg">Message <span class="req">*</span></label>
            <textarea id="cMsg" name="message" required maxlength="1500" placeholder="How can we help? (Please do not share medical reports or sensitive documents here)"></textarea>
            <span class="error-msg">Please write your message.</span>
          </div>
          <div class="form-field form-field--full">
            <label class="form-consent">
              <input type="checkbox" name="consent" value="1" required>
              <span>I consent to Deccan Malti Hospital contacting me regarding this enquiry. <span class="req">*</span></span>
            </label>
          </div>
        </div>
        <button type="submit" class="btn btn--accent" style="margin-top:var(--sp-3);"><?= icon('send', 'icon icon--sm') ?> Send Message</button>
        <div class="form-status" id="contactStatus" role="status" aria-live="polite"></div>
      </form>
    </div>
  </div>
</section>
