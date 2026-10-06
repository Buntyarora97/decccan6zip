<?php
/**
 * Reusable appointment form. Optional preselects via $_GET: ?department=&doctor=
 */
$depts = dm_departments();
$doctorsList = dm_doctors();
$preDept = $_GET['department'] ?? '';
$preDoc  = $_GET['doctor'] ?? '';
?>
<form class="form-card" method="post" action="<?= e(dm_url('api/appointment.php')) ?>" data-ajax data-status-target="apptStatus" novalidate>
  <?= csrf_field() ?>
  <!-- Honeypot (bots ke liye — humans ko dikhta nahi) -->
  <div class="form-honeypot" aria-hidden="true">
    <label>Leave this field empty <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
  </div>
  <!-- UTM/source tracking -->
  <input type="hidden" name="utm_source" value="<?= e($_GET['utm_source'] ?? '') ?>">
  <input type="hidden" name="utm_medium" value="<?= e($_GET['utm_medium'] ?? '') ?>">
  <input type="hidden" name="utm_campaign" value="<?= e($_GET['utm_campaign'] ?? '') ?>">

  <div class="form-grid">
    <div class="form-field">
      <label for="apptName">Patient Name <span class="req">*</span></label>
      <input type="text" id="apptName" name="patient_name" required maxlength="120" autocomplete="name">
      <span class="error-msg">Please enter the patient's name.</span>
    </div>
    <div class="form-field">
      <label for="apptMobile">Mobile Number <span class="req">*</span></label>
      <input type="tel" id="apptMobile" name="mobile" required maxlength="15" inputmode="tel" autocomplete="tel" placeholder="+91 ">
      <span class="error-msg">Please enter a valid 10-digit mobile number.</span>
    </div>
    <div class="form-field">
      <label for="apptEmail">Email <small style="font-weight:500;color:var(--text-muted);">(optional)</small></label>
      <input type="email" id="apptEmail" name="email" maxlength="190" autocomplete="email">
      <span class="error-msg">Please enter a valid email address.</span>
    </div>
    <div class="form-field">
      <label for="apptAge">Age <small style="font-weight:500;color:var(--text-muted);">(optional)</small></label>
      <input type="number" id="apptAge" name="age" min="0" max="120" inputmode="numeric">
    </div>
    <div class="form-field">
      <label for="apptDept">Department <span class="req">*</span></label>
      <select id="apptDept" name="department" required>
        <option value="">Select department</option>
        <?php foreach ($depts as $slug => $d): ?>
        <option value="<?= e($slug) ?>" <?= $preDept === $slug ? 'selected' : '' ?>><?= e($d['name']) ?></option>
        <?php endforeach; ?>
        <option value="not-sure">Not sure — help me choose</option>
      </select>
      <span class="error-msg">Please select a department.</span>
    </div>
    <div class="form-field">
      <label for="apptDoctor">Preferred Doctor <small style="font-weight:500;color:var(--text-muted);">(optional)</small></label>
      <select id="apptDoctor" name="doctor">
        <option value="">No preference</option>
        <?php foreach ($doctorsList as $slug => $doc): if (empty($doc['published'])) continue; ?>
        <option value="<?= e($doc['name']) ?>" <?= $preDoc === $slug ? 'selected' : '' ?>><?= e($doc['name']) ?> — <?= e($doc['speciality']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-field">
      <label for="apptDate">Preferred Date</label>
      <input type="date" id="apptDate" name="preferred_date" min="<?= date('Y-m-d') ?>">
    </div>
    <div class="form-field">
      <label for="apptTime">Preferred Time Window</label>
      <select id="apptTime" name="preferred_time">
        <option value="">Any time</option>
        <option>Morning</option>
        <option>Afternoon</option>
        <option>Evening</option>
      </select>
    </div>
    <div class="form-field">
      <label for="apptType">Visit Type</label>
      <select id="apptType" name="patient_type">
        <option value="new">New patient</option>
        <option value="follow_up">Follow-up visit</option>
      </select>
    </div>
    <div class="form-field form-field--full">
      <label for="apptMsg">Brief Message <small style="font-weight:500;color:var(--text-muted);">(optional — please do not share reports or sensitive medical documents here)</small></label>
      <textarea id="apptMsg" name="message" maxlength="1000" placeholder="Briefly describe the concern, e.g. back pain since 3 months"></textarea>
    </div>
    <div class="form-field form-field--full">
      <label class="form-consent">
        <input type="checkbox" name="consent" value="1" required>
        <span>I consent to Deccan Malti Hospital contacting me regarding this appointment request, and to my details being stored securely for this purpose. <span class="req">*</span></span>
      </label>
    </div>
  </div>

  <button type="submit" class="btn btn--booking" style="margin-top:var(--sp-3);">
    <?= icon('calendar', 'icon icon--sm') ?> Request Appointment
  </button>
  <p class="hint" style="margin-top:12px;font-size:13px;color:var(--text-muted);">This is a request, not a confirmed appointment. Our team will call you to confirm the slot.</p>
  <div class="form-status" id="apptStatus" role="status" aria-live="polite"></div>
</form>
