<?php
/** Insurance & cashless assistance */
require_once __DIR__ . '/../includes/breadcrumbs.php';
$faqs = [
    ['q' => 'Can I use cashless insurance?', 'a' => 'Cashless eligibility depends on your insurer, policy, treatment and current network status. Confirm those details with the hospital and your insurer. Any cashless approval is made by the insurer.'],
    ['q' => 'Which documents might an insurer request?', 'a' => 'Requirements vary. An insurer may request policy information, patient identification and relevant clinical documents. Ask the insurer and hospital which documents apply to your case; do not send sensitive documents through this website form.'],
    ['q' => 'How long does pre-authorisation take?', 'a' => 'Processing times vary by insurer, policy, treatment and the information requested. Ask your insurer about expected timing and contact the hospital if you need to confirm current arrangements.'],
    ['q' => 'What if cashless approval is not granted?', 'a' => 'Ask the insurer to explain its decision and discuss possible next steps with the hospital. Reimbursement, if available, depends on your policy and insurer review.'],
    ['q' => 'Which costs are covered?', 'a' => 'Coverage, limits, exclusions and patient contributions vary by policy and treatment. Review your policy and ask your insurer for case-specific information before making financial decisions.'],
    ['q' => 'What should I do in a medical emergency?', 'a' => 'Do not delay urgent care while checking insurance. For a life-threatening emergency, call local emergency services or go to the nearest emergency facility.'],
];
echo dm_schema_faq($faqs);
?>
<section class="page-hero">
  <div class="container">
    <?php dm_breadcrumbs(['Home' => '', 'Insurance & Empanelment Assistance' => null]); ?>
    <h1>Insurance &amp; Empanelment Assistance</h1>
    <p class="lead" style="max-width:760px;">Ask the hospital team to check policy-specific network status and explain the cashless process. Eligibility, coverage and approvals are determined by your insurer.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section__head reveal">
      <span class="eyebrow">The Process</span>
      <h2>Questions to check before planning care</h2>
    </div>
    <div class="insurance-steps">
      <div class="insurance-step reveal"><strong>Check network status</strong><p>Ask the hospital and insurer whether the policy and proposed treatment are currently eligible for a cashless process.</p></div>
      <div class="insurance-step reveal reveal-delay-1"><strong>Confirm requirements</strong><p>Ask the insurer which documents and forms are required for your specific enquiry.</p></div>
      <div class="insurance-step reveal reveal-delay-2"><strong>Allow for insurer review</strong><p>Pre-authorisation timing and decisions are controlled by the insurer and can vary.</p></div>
      <div class="insurance-step reveal reveal-delay-3"><strong>Confirm costs and next steps</strong><p>Check policy limits, exclusions, approval status and any payment responsibility before proceeding.</p></div>
    </div>

    <div class="grid grid--2" style="margin-top:var(--sp-6);align-items:start;">
      <div class="bring-card reveal" style="margin-top:0;">
        <h3><?= icon('document-check', 'icon icon--sm') ?> Documents checklist</h3>
        <ul style="grid-template-columns:1fr;">
          <li><?= icon('check', 'icon') ?> Insurance card or policy details, if requested</li>
          <li><?= icon('check', 'icon') ?> Patient identification, if requested</li>
          <li><?= icon('check', 'icon') ?> Relevant clinical reports, if requested</li>
          <li><?= icon('check', 'icon') ?> Previous hospitalisation information, if relevant</li>
          <li><?= icon('check', 'icon') ?> Any insurer or hospital forms required for your case</li>
        </ul>
      </div>
      <div class="card reveal reveal-delay-1">
        <h3 style="margin-bottom:12px;">Planned vs emergency admission</h3>
        <p style="font-size:14.5px;color:var(--text-soft);"><strong style="color:var(--navy);">Planned care:</strong> Contact the hospital and insurer early to ask about current network status, documents and expected review timing.</p>
        <p style="font-size:14.5px;color:var(--text-soft);"><strong style="color:var(--navy);">Emergency:</strong> Seek urgent care first. Insurance checks must not delay emergency help.</p>
        <div class="urgent-note" style="margin:14px 0 0;">
          <?= icon('info', 'icon') ?>
          <div><strong>Important</strong><p>Cashless approval, coverage amount and exclusions are decided by your insurer under your policy terms. The hospital cannot guarantee an insurer's decision.</p></div>
        </div>
      </div>
    </div>

    <div class="partner-placeholder reveal" id="empanelment-help" style="margin-top:var(--sp-5);">
      <?= icon('shield', 'icon') ?>
      <p style="margin-top:8px;"><strong>Insurer and TPA network enquiries:</strong> contact the hospital team to confirm policy-specific empanelment status. No partner or approval is implied by this website.</p>
    </div>
    <div class="facility-support-note reveal" id="cmrf-help" style="margin-top:var(--sp-3);">
      <?= icon('hand', 'icon') ?>
      <div>
        <h3>Chief Minister’s Relief Fund (CMRF) guidance</h3>
        <p>The hospital can provide guidance for enquiries. Eligibility and financial assistance depend on programme rules, documentation and approval by the relevant authority.</p>
      </div>
    </div>
  </div>
</section>

<!-- Eligibility enquiry form -->
<section class="section section--soft">
  <div class="container">
    <div class="grid" style="grid-template-columns:1fr 1.3fr;align-items:start;">
      <div class="reveal">
        <span class="eyebrow">Insurance &amp; Empanelment Enquiry</span>
        <h2>Not sure if your policy covers your treatment?</h2>
        <p class="lead">Send a general enquiry and the hospital team can respond using the contact details you provide. Do not include policy numbers or sensitive medical or identity documents.</p>
        <p style="margin-top:16px;color:var(--text-soft);">Or call directly: <a href="tel:<?= e(DM_PHONE) ?>"><strong><?= e(DM_PHONE_DISPLAY) ?></strong></a></p>
      </div>
      <form class="form-card reveal reveal-delay-1" id="insurance-enquiry-form" method="post" action="<?= e(dm_url('api/insurance.php')) ?>" data-ajax data-status-target="insStatus" novalidate>
        <?= csrf_field() ?>
        <div class="form-honeypot" aria-hidden="true"><label>Leave empty <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
        <div class="form-grid">
          <div class="form-field">
            <label for="iName">Your Name <span class="req">*</span></label>
            <input type="text" id="iName" name="name" required maxlength="120">
            <span class="error-msg">Please enter your name.</span>
          </div>
          <div class="form-field">
            <label for="iMobile">Mobile <span class="req">*</span></label>
            <input type="tel" id="iMobile" name="mobile" required maxlength="15" inputmode="tel">
            <span class="error-msg">Please enter a valid mobile number.</span>
          </div>
          <div class="form-field">
            <label for="iEmail">Email</label>
            <input type="email" id="iEmail" name="email" maxlength="190">
          </div>
          <div class="form-field">
            <label for="iInsurer">Insurance Company / TPA</label>
            <input type="text" id="iInsurer" name="insurer" maxlength="120" placeholder="Optional">
          </div>
          <div class="form-field form-field--full">
            <label for="iType">Admission Type</label>
            <select id="iType" name="admission_type">
              <option value="planned">Planned treatment</option>
              <option value="emergency">Emergency</option>
              <option value="not_sure" selected>Not sure yet</option>
            </select>
          </div>
          <div class="form-field form-field--full">
            <label for="iMsg">Brief details</label>
            <textarea id="iMsg" name="message" maxlength="800" placeholder="Which treatment/department is this regarding?"></textarea>
          </div>
          <div class="form-field form-field--full">
            <label class="form-consent">
              <input type="checkbox" name="consent" value="1" required>
              <span>I consent to being contacted about my insurance enquiry. <span class="req">*</span></span>
            </label>
          </div>
        </div>
        <button type="submit" class="btn btn--accent" style="margin-top:var(--sp-3);"><?= icon('shield', 'icon icon--sm') ?> Send Insurance Enquiry</button>
        <div class="form-status" id="insStatus" role="status" aria-live="polite"></div>
      </form>
    </div>
  </div>
</section>

<section class="section">
  <div class="container" style="max-width:860px;">
    <div class="section__head section__head--center reveal">
      <span class="eyebrow" style="justify-content:center;">FAQs</span>
      <h2>Insurance questions, answered</h2>
    </div>
    <?php foreach ($faqs as $f): ?>
    <details class="faq-item reveal">
      <summary><?= e($f['q']) ?> <?= icon('chevron-down', 'icon icon--sm') ?></summary>
      <div class="faq-item__body"><?= e($f['a']) ?></div>
    </details>
    <?php endforeach; ?>
  </div>
</section>
