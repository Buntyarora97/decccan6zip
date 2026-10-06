<?php
/**
 * Site-wide verified facts (official website se) + shared lists.
 * Yahan sirf verified information hai — kuch bhi naya add karne se pehle verify karein.
 */
declare(strict_types=1);

// ---------- Verified contact details ----------
define('DM_PHONE', '+918830006879');
define('DM_PHONE_DISPLAY', '+91 883 000 6879');
define('DM_LANDLINE', '02332324834');
define('DM_LANDLINE_DISPLAY', '0233-2324834');
define('DM_ADDRESS', 'Opp. Ambassador Hotel, Besides Sushil Hospital, Sangli–Miraj Road, Vishrambag, Sangli, Maharashtra – 416415');
define('DM_MAPS_URL', 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode('Deccan Malti Neuro & Superspeciality Hospital, Vishrambag, Sangli, Maharashtra 416415'));
define('DM_WHATSAPP', 'https://wa.me/918830006879?text=' . rawurlencode('Hello Deccan Malti Hospital, I would like to book an appointment.'));

// Official social profiles
define('DM_FACEBOOK', 'https://www.facebook.com/p/Deccan-Malti-Hospital-61551072004436/');
define('DM_INSTAGRAM', 'https://www.instagram.com/deccanmaltihospital/');
define('DM_X', 'https://x.com/dmhospital');
define('DM_YOUTUBE', '');

// ---------- Navigation structure ----------
function dm_nav(): array
{
    return [
        ['label' => 'Home',        'url' => ''],
        ['label' => 'About',       'url' => 'about',       'mega' => 'about'],
        ['label' => 'Services',    'url' => 'departments', 'mega' => 'services'],
        ['label' => 'Doctors',     'url' => 'doctors',     'mega' => 'doctors'],
        ['label' => 'Facilities',  'url' => 'facilities'],
        ['label' => 'Patient Care','url' => 'patient-care','mega' => 'patient'],
        ['label' => 'Blog',        'url' => 'health-library'],
        ['label' => 'Contact',     'url' => 'contact'],
    ];
}

/** Full public-facing service catalogue shared by menus, homepage and service overview. */
function dm_services(): array
{
    static $services = null;
    if ($services === null) {
        $services = require __DIR__ . '/services.php';
    }
    return $services;
}

/** Point existing departments to their detail page and all others to their service card. */
function dm_service_url(array $service): string
{
    if (!empty($service['department'])) {
        return dm_url('departments/' . $service['department']);
    }
    return dm_url('departments#service-' . $service['id']);
}

/** Find the catalogue entry backing an existing specialist-detail route. */
function dm_service_for_department(string $departmentSlug): ?array
{
    foreach (dm_services() as $category) {
        foreach ($category['groups'] as $items) {
            foreach ($items as $service) {
                if (($service['department'] ?? null) === $departmentSlug) {
                    return $service;
                }
            }
        }
    }
    return null;
}

/** Downloadable hospital guide generated from confirmed website content and current photos. */
function dm_brochure_url(): string
{
    return dm_url('assets/docs/deccan-malti-hospital-guide.pdf');
}

/** Public, fact-checked facilities catalogue shared by overview and facility pages. */
function dm_facilities(): array
{
    static $facilities = null;
    if ($facilities === null) {
        $facilities = require __DIR__ . '/facilities.php';
    }
    return $facilities;
}

/** Department list (slug => basic info) — full content data/departments.php mein */
function dm_department_index(): array
{
    static $idx = null;
    if ($idx === null) {
        $all = dm_departments();
        $idx = [];
        foreach ($all as $slug => $d) {
            $idx[$slug] = [
                'name'    => $d['name'],
                'icon'    => $d['icon'],
                'summary' => $d['summary'],
            ];
        }
    }
    return $idx;
}

/** Patient care sub pages */
function dm_patient_care_pages(): array
{
    return [
        'appointment'                      => 'Appointment Guide',
        'admission-discharge'              => 'Admission & Discharge',
        'visitor-information'              => 'Visitor Information',
        'patient-rights-responsibilities'  => 'Patient Rights & Responsibilities',
        'medical-records'                  => 'Medical Records',
    ];
}
