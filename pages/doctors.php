<?php
/** Doctors directory — search + department filter */
require_once __DIR__ . '/../includes/breadcrumbs.php';
$doctors = dm_doctors();
$depts = dm_departments();

// slug → department mapping (search filter ke liye)
$docDept = ['dr-p-c-patil' => 'general-surgery', 'dr-rohan-patil' => 'neurosurgery'];
?>
<section class="page-hero">
  <div class="container">
    <?php dm_breadcrumbs(['Home' => '', 'Find a Doctor' => null]); ?>
    <h1>Find a Doctor</h1>
    <p class="lead" style="max-width:700px;">Verified specialists at Deccan Malti Hospital, Sangli. Profiles are published only after credential verification — no exceptions.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="filter-bar reveal">
      <label class="sr-only" for="doctorSearch">Search doctors</label>
      <input type="search" id="doctorSearch" placeholder="Search by name or speciality…" autocomplete="off">
      <label class="sr-only" for="doctorDeptFilter">Filter by department</label>
      <select id="doctorDeptFilter">
        <option value="all">All Departments</option>
        <?php foreach ($depts as $slug => $d): ?>
        <option value="<?= e($slug) ?>"><?= e($d['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="grid grid--3 doctor-directory">
      <?php $i=0; foreach ($doctors as $slug => $doc): if (empty($doc['published'])) continue; ?>
      <div class="doctor-card-wrap reveal<?= $i%3 ? ' reveal-delay-'.($i%3) : '' ?>"
           data-name="<?= e(strtolower($doc['name'])) ?>"
           data-spec="<?= e(strtolower($doc['speciality'])) ?>"
           data-dept="<?= e($docDept[$slug] ?? '') ?>">
        <div class="doctor-card">
          <div class="doctor-card__img">
            <img src="<?= e(dm_url($doc['image'])) ?>" alt="<?= e($doc['name']) ?>, <?= e($doc['speciality']) ?>, Deccan Malti Hospital Sangli" width="480" height="400" loading="lazy">
          </div>
          <div class="doctor-card__body">
            <span class="doctor-card__spec"><?= e($doc['speciality']) ?></span>
            <h3><?= e($doc['name']) ?></h3>
            <p class="doctor-card__quals"><?= e(implode(', ', $doc['qualifications'])) ?></p>
            <p class="doctor-card__exp"><?= e($doc['experience']) ?></p>
            <div class="doctor-card__actions">
              <a href="<?= e(dm_url('doctors/' . $slug)) ?>" class="btn btn--outline btn--sm">View Profile</a>
              <a href="<?= e(dm_url('appointment')) ?>?doctor=<?= e($slug) ?>" class="btn btn--primary btn--sm">Book</a>
            </div>
          </div>
        </div>
      </div>
      <?php $i++; endforeach; ?>
    </div>

    <div class="partner-placeholder reveal" style="margin-top:var(--sp-5);">
      <?= icon('users', 'icon') ?>
      <p style="margin-top:8px;">More specialist profiles will appear here as visiting consultants' credentials are verified and approved. To consult a specialist in any department, call <?= e(DM_PHONE_DISPLAY) ?>.</p>
    </div>
  </div>
</section>
