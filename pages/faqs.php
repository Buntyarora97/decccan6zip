<?php
/** General FAQs */
require_once __DIR__ . '/../includes/breadcrumbs.php';
$faqs = [
    ['q' => 'Where is Deccan Malti Hospital located?', 'a' => 'We are on Sangli–Miraj Road in Vishrambag, Sangli — opposite Ambassador Hotel, beside Sushil Hospital, Sangli, Maharashtra 416415. The location is easy to reach from anywhere in Sangli district; use the Get Directions link on our contact page for live navigation.'],
    ['q' => 'How do I request an appointment?', 'a' => 'Use the appointment form on this website or call ' . DM_PHONE_DISPLAY . '. Contact the hospital to confirm appointment availability and timing.'],
    ['q' => 'Which services does the hospital list?', 'a' => 'The service directory lists clinical specialities, diagnostic services and allied support. Browse the complete Services page for the current website list.'],
    ['q' => 'What should I bring to my first consultation?', 'a' => 'Relevant previous reports, scans, prescriptions and a list of current medicines may help the clinician review your history. Contact the hospital if you need visit-specific instructions.'],
    ['q' => 'What should I do in a medical emergency?', 'a' => 'For a life-threatening emergency, call local emergency services or go to the nearest emergency facility. Do not delay urgent care while checking this website.'],
    ['q' => 'Can I ask about cashless insurance?', 'a' => 'Yes. Contact the hospital and your insurer to check current network status and policy-specific requirements. Eligibility and approval are determined by your insurer.'],
    ['q' => 'How can I request medical records?', 'a' => 'Contact the hospital to ask about its current medical-record request process and any identification or authorisation requirements.'],
    ['q' => 'What are the visiting hours?', 'a' => 'Please confirm current visiting hours at reception or by calling ' . DM_LANDLINE_DISPLAY . ', as timings may change with the clinical situation. Visitors with fever, cold or cough are requested not to visit, for patient safety.'],
];
echo dm_schema_faq($faqs);
?>
<section class="page-hero">
  <div class="container">
    <?php dm_breadcrumbs(['Home' => '', 'FAQs' => null]); ?>
    <h1>Frequently Asked Questions</h1>
    <p class="lead" style="max-width:680px;">Quick answers about appointments, visits, insurance and records.</p>
  </div>
</section>

<section class="section">
  <div class="container" style="max-width:860px;">
    <?php foreach ($faqs as $f): ?>
    <details class="faq-item reveal">
      <summary><?= e($f['q']) ?> <?= icon('chevron-down', 'icon icon--sm') ?></summary>
      <div class="faq-item__body"><?= e($f['a']) ?></div>
    </details>
    <?php endforeach; ?>
    <div style="margin-top:var(--sp-6);"><?php require __DIR__ . '/../includes/cta-strip.php'; ?></div>
  </div>
</section>
