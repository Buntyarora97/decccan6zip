<?php
/**
 * Front controller / router — clean URLs yahan resolve hote hain.
 */
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/seo.php';

$path = dm_path();
$path = $path === '' ? '' : rtrim($path, '/');

// ---------- Route table ----------
$routes = [
    '' => [
        'file'  => 'pages/home.php',
        'title' => 'Neuro & Superspeciality Hospital in Sangli | Deccan Malti',
        'desc'  => 'Specialist care in Sangli for brain, spine, heart and joint conditions. Meet Deccan Malti Hospital’s doctors, explore specialist departments and request an appointment.',
        'preloadImage' => 'assets/img/hospital-shoot/hospital-exterior-garden-view.webp',
    ],
    'about' => [
        'file'  => 'pages/about.php',
        'title' => 'About Deccan Malti Hospital in Sangli | Our Story',
        'desc'  => 'Discover Deccan Malti Hospital in Vishrambag, Sangli—its founding story, listed specialist departments and patient-centred approach to local care.',
    ],
    'leadership' => [
        'file'  => 'pages/leadership.php',
        'title' => 'Hospital Founders & Leadership in Sangli | Deccan Malti',
        'desc'  => 'Meet Deccan Malti Hospital co-founders Dr. P. C. Patil and Dr. Rohan Patil in Sangli. Read about their general-surgery and neurosurgery roles and approach.',
    ],
    'doctors' => [
        'file'  => 'pages/doctors.php',
        'title' => 'Doctors & Specialists in Sangli | Deccan Malti Hospital',
        'desc'  => 'Find doctors at Deccan Malti Hospital, Sangli. View profiles for neurosurgeon Dr. Rohan Patil and general surgeon Dr. P. C. Patil, then request a consultation.',
    ],
    'departments' => [
        'file'  => 'pages/departments.php',
        'title' => 'Hospital Services & Specialities in Sangli | Deccan Malti',
        'desc'  => 'Browse clinical, diagnostic and supportive services at Deccan Malti Hospital in Sangli, including neurosurgery, neurology, radiology, CT scan, laboratory services and physiotherapy.',
    ],
    'facilities' => [
        'file'  => 'pages/facilities.php',
        'title' => 'Hospital Facilities & Rooms in Sangli | Deccan Malti',
        'desc'  => 'Explore emergency and critical-care categories, room types, diagnostic infrastructure, pharmacy and patient support services at Deccan Malti Hospital, Sangli.',
    ],
    'patient-care' => [
        'file'  => 'pages/patient-care.php',
        'title' => 'Patient Care Guide | Deccan Malti Hospital, Sangli',
        'desc'  => 'Plan your visit to Deccan Malti Hospital, Sangli. Find guidance for appointments, admission and discharge, visitors, medical records and patient rights.',
    ],
    'insurance' => [
        'file'  => 'pages/insurance.php',
        'title' => 'Insurance & Empanelment Assistance | Deccan Malti',
        'desc'  => 'Ask Deccan Malti Hospital in Sangli about policy-specific network status and cashless insurance. Coverage and approvals depend on the insurer and policy.',
    ],
    'testimonials' => [
        'file'  => 'pages/testimonials.php',
        'title' => 'Patient Reviews | Deccan Malti Hospital, Sangli',
        'desc'  => 'Read genuine, unedited patient reviews from Deccan Malti Hospital’s Google listing. Open Google to see the original wording, reviewer context and current reviews.',
    ],
    'gallery' => [
        'file'  => 'pages/gallery.php',
        'title' => 'Hospital Photo Gallery | Deccan Malti, Sangli',
        'desc'  => 'View full-frame photographs of Deccan Malti Hospital in Vishrambag, Sangli, including the exterior, emergency entrance, diagnostic areas and interiors.',
    ],
    'health-library' => [
        'file'  => 'pages/health-library.php',
        'title' => 'Hospital Blog & Health Articles | Deccan Malti, Sangli',
        'desc'  => 'Read patient-friendly health articles from Deccan Malti Hospital, Sangli, covering brain, spine, heart, joints and general health for education and awareness.',
    ],
    'faqs' => [
        'file'  => 'pages/faqs.php',
        'title' => 'Hospital FAQs | Deccan Malti Hospital, Sangli',
        'desc'  => 'Find answers about appointments, visiting, insurance and hospital services at Deccan Malti Hospital, Vishrambag, Sangli, before planning a patient visit.',
    ],
    'contact' => [
        'file'  => 'pages/contact.php',
        'title' => 'Contact Deccan Malti Hospital in Sangli | Directions',
        'desc'  => 'Contact Deccan Malti Hospital in Vishrambag, Sangli for directions, appointment requests and general enquiries. Call the hospital or send an online message.',
    ],
    'appointment' => [
        'file'  => 'pages/appointment.php',
        'title' => 'Book a Hospital Appointment in Sangli | Deccan Malti',
        'desc'  => 'Request an appointment with a specialist at Deccan Malti Hospital, Sangli. Choose a department and the patient-care team will call to confirm your preferred slot.',
    ],
    'privacy-policy' => [
        'file'  => 'pages/privacy-policy.php',
        'title' => 'Privacy Policy | Deccan Malti Hospital, Sangli',
        'desc'  => 'Read how Deccan Malti Hospital in Sangli collects, uses and protects information submitted through this website and its online appointment and enquiry forms.',
    ],
    'terms-conditions' => [
        'file'  => 'pages/terms-conditions.php',
        'title' => 'Website Terms | Deccan Malti Hospital, Sangli',
        'desc'  => 'Read the terms for using the Deccan Malti Hospital website, including guidance about online information, external links, enquiries and visitor responsibilities.',
    ],
    'medical-disclaimer' => [
        'file'  => 'pages/medical-disclaimer.php',
        'title' => 'Medical Disclaimer | Deccan Malti Hospital, Sangli',
        'desc'  => 'Read the Deccan Malti Hospital medical disclaimer: website information is educational and does not replace advice, diagnosis or treatment from a qualified clinician.',
    ],
];

// ---------- Dynamic routes ----------
$seo = ['title' => '', 'desc' => '', 'image' => 'assets/img/hospital-shoot/hospital-exterior-front.webp'];
$file = null;
$params = [];

if (isset($routes[$path])) {
    $file = $routes[$path]['file'];
    $seo['title'] = $routes[$path]['title'];
    $seo['desc']  = $routes[$path]['desc'];
    $seo['canonical'] = dm_url($path);
} elseif (preg_match('#^departments/([a-z0-9-]+)$#', $path, $m)) {
    $depts = dm_departments();
    $slug = $m[1];
    if (isset($depts[$slug])) {
        $file = 'pages/department-single.php';
        $params['dept'] = $depts[$slug];
        $params['slug'] = $slug;
        $seo['title'] = dm_seo_department_title($depts[$slug]['name']);
        $service = dm_service_for_department($slug);
        $seo['desc']  = dm_seo_department_description($slug, $service['summary'] ?? $depts[$slug]['summary']);
        $seo['image'] = 'assets/img/hospital-shoot/hospital-exterior-front.webp';
        $seo['canonical'] = dm_url($path);
    }
} elseif (preg_match('#^doctors/([a-z0-9-]+)$#', $path, $m)) {
    $doctors = dm_doctors();
    $slug = $m[1];
    if (isset($doctors[$slug]) && !empty($doctors[$slug]['published'])) {
        $file = 'pages/doctor-profile.php';
        $params['doctor'] = $doctors[$slug];
        $params['slug'] = $slug;
        $seo['title'] = dm_seo_doctor_title($doctors[$slug]);
        $seo['desc']  = dm_seo_doctor_description($slug, $doctors[$slug]['intro']);
        $seo['canonical'] = dm_url($path);
    }
} elseif (preg_match('#^health-library/([a-z0-9-]+)$#', $path, $m)) {
    $articles = dm_articles();
    $slug = $m[1];
    if (isset($articles[$slug])) {
        $file = 'pages/article.php';
        $params['article'] = $articles[$slug];
        $params['slug'] = $slug;
        $seo['title'] = dm_seo_article_title($slug, $articles[$slug]['title']);
        $seo['desc']  = dm_seo_article_description($slug, $articles[$slug]['excerpt']);
        $seo['image'] = 'assets/img/hospital-shoot/hospital-exterior-front.webp';
        $seo['canonical'] = dm_url($path);
        $seo['ogType'] = 'article';
        $seo['published'] = $articles[$slug]['published'];
        $seo['updated'] = $articles[$slug]['updated'];
    }
} elseif (preg_match('#^patient-care/([a-z0-9-]+)$#', $path, $m)) {
    $pc = dm_patient_care_pages();
    $slug = $m[1];
    if (isset($pc[$slug])) {
        $file = 'pages/patient-care-page.php';
        $params['pc_slug'] = $slug;
        $params['pc_title'] = $pc[$slug];
        $seo['title'] = dm_seo_patient_care_title($pc[$slug]);
        $seo['desc']  = dm_seo_patient_care_description($slug, $pc[$slug]);
        $seo['canonical'] = dm_url($path);
    }
}

// ---------- 404 ----------
if ($file === null || !file_exists(__DIR__ . '/' . $file)) {
    http_response_code(404);
    $file = 'pages/404.php';
    $seo['title'] = 'Page Not Found | Deccan Malti Hospital, Sangli';
    $seo['desc']  = 'The page you are looking for could not be found. Use the links below to reach departments, doctors or contact Deccan Malti Hospital, Sangli.';
    $seo['robots'] = 'noindex, follow';
    unset($seo['canonical']);
}

extract($params, EXTR_SKIP);

// ---------- Render ----------
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/' . $file;
require __DIR__ . '/includes/footer.php';
