<?php
/** Patient care sub-pages — vars: $pc_slug, $pc_title */
require_once __DIR__ . '/../includes/breadcrumbs.php';

$content = [
    'appointment' => [
        ['h' => 'How to book', 'p' => 'Request an appointment using the form on this website, or contact the hospital by phone or WhatsApp. Online and WhatsApp messages are appointment enquiries; contact the hospital to confirm a suitable time.'],
        ['h' => 'Before your visit', 'p' => 'Bring previous consultation papers, investigation reports and scans when relevant, and make a list of current medicines. If you plan to ask about insurance, bring the policy details requested by your insurer. Contact the hospital to confirm the arrival time and any documents for your visit.'],
        ['h' => 'During the consultation', 'p' => 'Share your health history, medicines, allergies and questions with the clinician. You can ask about examination findings, the purpose of any suggested test, available options and associated costs before making a decision.'],
        ['h' => 'Follow-up visits', 'p' => 'Discuss follow-up timing and instructions with your clinician. Bring earlier reports and a current medicine list, and mention any changes or questions since the previous visit.'],
    ],
    'admission-discharge' => [
        ['h' => 'Planned admission', 'p' => 'For a planned admission, confirm the date, any fasting instructions and what to bring with the treating team. Ask the insurer about its documents and pre-authorisation process early; processing requirements and timing vary.'],
        ['h' => 'During your stay', 'p' => 'Ask the hospital team about identification checks, daily arrangements, visiting guidance and any ward-specific instructions. Attendant arrangements may depend on the room or ward and clinical requirements; confirm the current policy with the hospital.'],
        ['h' => 'Discharge', 'p' => 'Before leaving, ask the treating team what follow-up, medicine, wound-care or activity instructions apply to you, and which records you should keep. Ask for clarification if an instruction is unclear.'],
        ['h' => 'Billing', 'p' => 'Ask the hospital about available billing details and any charge you do not understand. Insurance coverage, approval, patient contributions and reimbursement documents depend on your policy and insurer.'],
    ],
    'visitor-information' => [
        ['h' => 'Visiting your loved one', 'p' => 'Visiting hours and access arrangements can vary with the clinical situation. Confirm the current guidance at reception or by calling ' . DM_LANDLINE_DISPLAY . '.'],
        ['h' => 'During your visit', 'p' => 'Follow the instructions given by hospital staff, including any hand-hygiene or infection-prevention guidance. Ask before bringing food, flowers or children into patient areas; restrictions may apply. If you feel unwell, contact the hospital before visiting.'],
        ['h' => 'For attendants', 'p' => 'Confirm attendant arrangements, what to bring and whether an attendant may be present for discharge discussions with the hospital team. These details may vary by ward and clinical requirements.'],
    ],
    'patient-rights-responsibilities' => [
        ['h' => 'Questions about your care', 'p' => 'You can ask the clinical team to explain your assessment, suggested options, risks and costs, and to discuss consent before a procedure. You may ask about obtaining your records or seeking another opinion; contact the hospital team about the relevant process.'],
        ['h' => 'Your responsibilities as a patient', 'p' => 'Good care is a partnership. Please provide complete and honest information about your health, medicines and allergies; follow the treatment plan you agreed to or tell us why you cannot; attend follow-up appointments; treat staff and fellow patients with respect; and ask questions whenever anything is unclear.'],
        ['h' => 'Feedback and complaints', 'p' => 'If you have a concern, contact the nursing station or hospital administration to ask how to raise it and what the next steps are.'],
    ],
    'medical-records' => [
        ['h' => 'Requesting your records', 'p' => 'Contact reception or the hospital team to ask about copies of reports, summaries or bills. Confirm which identification or visit details are required and how to submit a request.'],
        ['h' => 'Authorised requests', 'p' => 'If someone is requesting records on a patient\'s behalf, ask the hospital what consent and supporting documents are required. Processing arrangements may vary by record and request.'],
        ['h' => 'Privacy of your records', 'p' => 'For information about how personal and medical records are handled, review the hospital privacy policy or contact the hospital directly.'],
    ],
];

$blocks = $content[$pc_slug] ?? [];
?>
<section class="page-hero">
  <div class="container">
    <?php dm_breadcrumbs(['Home' => '', 'Patient Care' => 'patient-care', $pc_title => null]); ?>
    <h1><?= e($pc_title) ?></h1>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="grid" style="grid-template-columns:1.6fr 1fr;align-items:start;">
      <div class="prose reveal">
        <?php foreach ($blocks as $b): ?>
        <h2 style="font-size:24px;margin-top:var(--sp-4);"><?= e($b['h']) ?></h2>
        <p><?= e($b['p']) ?></p>
        <?php endforeach; ?>
        <p style="margin-top:var(--sp-4);font-size:13.5px;color:var(--text-muted);">For current details, contact the hospital at <?= e(DM_PHONE_DISPLAY) ?>.</p>
      </div>
      <aside class="cta-panel reveal reveal-delay-1">
        <h3>Need to book?</h3>
        <p>Submit an appointment request or call to ask about a suitable time.</p>
        <a href="<?= e(dm_url('appointment')) ?>" class="btn btn--accent"><?= icon('calendar', 'icon icon--sm') ?> Book Appointment</a>
        <a href="tel:<?= e(DM_PHONE) ?>" class="btn btn--ghost-light"><?= icon('phone', 'icon icon--sm') ?> <?= e(DM_PHONE_DISPLAY) ?></a>
      </aside>
    </div>
  </div>
</section>
