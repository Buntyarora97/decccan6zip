<?php
/**
 * SEO helpers — meta tags render + JSON-LD schema builders.
 */
declare(strict_types=1);

/** Page titles and descriptions for the public, data-driven routes. */
function dm_seo_department_title(string $name): string
{
    $title = $name . ' in Sangli | Deccan Malti Hospital';
    if (mb_strlen($title) > 65) {
        $title = $name . ' in Sangli | Deccan Malti';
    }
    return $title;
}

function dm_seo_department_description(string $slug, string $fallback): string
{
    $descriptions = [
        'cardiology' => 'Explore heart-care guidance in Sangli, including evaluation for chest pain, blood pressure, cholesterol and heart rhythm, at Deccan Malti Hospital.',
        'colorectal-surgery' => 'Learn about colorectal surgery evaluation in Sangli for piles, fissures, fistulas and bowel concerns. See when to seek help and request a visit.',
        'general-surgery' => 'Explore general surgery at Deccan Malti Hospital, Sangli, including assessment for hernia, gallbladder, appendix and other abdominal conditions.',
        'nephrology' => 'Learn about kidney care in Sangli, including chronic kidney disease, diabetes-related risk, blood pressure and dialysis guidance at Deccan Malti Hospital.',
        'neurology' => 'Explore neurology care in Sangli for brain, nerve and muscle conditions, including headache, epilepsy, stroke, movement disorders and neuropathy.',
        'neurosurgery' => 'Read about neurosurgical evaluation in Sangli for brain, spine and nerve conditions at Deccan Malti Hospital. View care information and request a consultation.',
        'oncology' => 'Learn how cancer evaluation, diagnosis coordination and treatment planning work at Deccan Malti Hospital in Sangli, with multi-speciality support.',
        'orthopaedics-joint-replacement' => 'Explore orthopaedic care in Sangli for bone and joint concerns, fractures, arthritis and knee or hip replacement evaluation at Deccan Malti Hospital.',
        'plastic-reconstructive-surgery' => 'Learn about reconstructive surgery evaluation in Sangli for injuries, wounds, burns and post-cancer reconstruction at Deccan Malti Hospital.',
        'urology' => 'Explore urology care in Sangli for kidney stones, prostate, urinary infection and bladder concerns. Review treatment guidance and request an appointment.',
    ];
    return $descriptions[$slug] ?? $fallback;
}

function dm_seo_doctor_title(array $doctor): string
{
    $role = $doctor['speciality'] === 'Neurosurgery' ? 'Neurosurgeon' : 'General Surgeon';
    return $doctor['name'] . ', ' . $role . ' in Sangli | Deccan Malti';
}

function dm_seo_doctor_description(string $slug, string $fallback): string
{
    $descriptions = [
        'dr-p-c-patil' => 'Meet Dr. P. C. Patil, general surgeon and co-founder at Deccan Malti Hospital in Sangli. View his profile, experience and how to request a consultation.',
        'dr-rohan-patil' => 'Meet Dr. Rohan Patil, neurosurgeon at Deccan Malti Hospital in Sangli. View his profile and brain and spine care information, then request a consultation.',
    ];
    return $descriptions[$slug] ?? $fallback;
}

function dm_seo_article_title(string $slug, string $fallback): string
{
    $titles = [
        'stroke-warning-signs' => 'Stroke Warning Signs and FAST | Deccan Malti Hospital',
        'understanding-back-pain' => 'Back Pain: Warning Signs & Care | Deccan Malti Hospital',
        'kidney-stones-guide' => 'Kidney Stones: Care & Prevention | Deccan Malti Hospital',
        'joint-pain-when-to-worry' => 'Joint Pain After 50 | Deccan Malti Hospital',
        'diabetes-and-your-body' => 'Diabetes: Protecting Your Health | Deccan Malti Hospital',
        'cancer-warning-signs' => 'Cancer Warning Signs | Deccan Malti Hospital',
        'hernia-questions-answered' => 'Hernia Questions Answered | Deccan Malti Hospital',
    ];
    return $titles[$slug] ?? $fallback;
}

function dm_seo_article_description(string $slug, string $fallback): string
{
    $descriptions = [
        'stroke-warning-signs' => 'Learn the FAST signs of stroke, what to do immediately and why time matters. This guide explains warning signs and the need for urgent emergency care.',
        'understanding-back-pain' => 'Most back pain improves, but weakness, numbness and bladder changes need assessment. Learn common warning signs, self-care basics and when to seek medical advice.',
        'kidney-stones-guide' => 'Understand kidney-stone symptoms, treatment and prevention. Learn which warning signs, including fever with pain, need urgent medical attention.',
        'joint-pain-when-to-worry' => 'Learn about knee and hip pain after 50, arthritis and graded care options. See when symptoms merit a medical review or joint-replacement evaluation.',
        'diabetes-and-your-body' => 'A practical guide to protecting your eyes, kidneys, nerves and heart with diabetes. Review routine checks and discuss your care plan with a clinician.',
        'cancer-warning-signs' => 'Learn common cancer warning signs and when persistent changes need medical review. This patient-friendly guide explains why timely assessment matters.',
        'hernia-questions-answered' => 'Learn what a hernia is, which symptoms need medical review and how treatment decisions are made, with clear answers to common patient questions.',
    ];
    return $descriptions[$slug] ?? $fallback;
}

function dm_seo_patient_care_title(string $title): string
{
    $full = $title . ' | Deccan Malti Hospital, Sangli';
    return mb_strlen($full) <= 65 ? $full : $title . ' | Deccan Malti';
}

function dm_seo_patient_care_description(string $slug, string $title): string
{
    $descriptions = [
        'appointment' => 'Prepare for a specialist appointment at Deccan Malti Hospital, Sangli. Find out how to request a visit, what to bring and how the team confirms a slot.',
        'admission-discharge' => 'Find practical admission and discharge guidance for patients and families at Deccan Malti Hospital, Sangli, including documents and the care team’s instructions.',
        'visitor-information' => 'Review visitor guidance before coming to Deccan Malti Hospital in Sangli, including where to ask for help and how to support a patient’s rest and privacy.',
        'patient-rights-responsibilities' => 'Read about patient rights, responsibilities and shared care decisions at Deccan Malti Hospital, Sangli, so patients and families know what to expect.',
        'medical-records' => 'Learn how to ask Deccan Malti Hospital in Sangli about medical records, reports and the information patients may need for follow-up care.',
    ];
    return $descriptions[$slug] ?? $title . ' — practical guidance for patients and families at Deccan Malti Hospital, Sangli.';
}

/** Hospital-level JSON-LD (har page par) */
function dm_schema_organization(): string
{
    $hospital = [
        '@type'    => 'Hospital',
        '@id'      => dm_url() . '#hospital',
        'name'     => 'Deccan Malti Neuro & Superspeciality Hospital',
        'url'      => dm_url(),
        'logo'     => dm_url('assets/img/brand-logo.png'),
        'image'    => dm_url('assets/img/hospital-shoot/hospital-exterior-front.webp'),
        'telephone' => DM_PHONE,
        'address'  => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'Opp. Ambassador Hotel, Besides Sushil Hospital, Sangli–Miraj Road, Vishrambag',
            'addressLocality' => 'Sangli',
            'addressRegion' => 'Maharashtra',
            'postalCode' => '416415',
            'addressCountry' => 'IN',
        ],
        'foundingDate' => '2023-03',
        'medicalSpecialty' => [
            'Neurosurgery', 'Neurology', 'Cardiology', 'Orthopedic',
            'PlasticSurgery', 'Oncologic', 'Urologic', 'Nephrology', 'GeneralSurgery',
        ],
        'sameAs' => array_values(array_filter([DM_FACEBOOK, DM_INSTAGRAM, DM_X, DM_YOUTUBE])),
    ];
    $website = [
        '@type' => 'WebSite',
        '@id' => dm_url() . '#website',
        'url' => dm_url(),
        'name' => SITE_NAME,
        'publisher' => ['@id' => dm_url() . '#hospital'],
        'inLanguage' => 'en-IN',
    ];
    $data = [
        '@context' => 'https://schema.org',
        '@graph' => [$hospital, $website],
    ];
    return '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
}

/** Breadcrumb JSON-LD */
function dm_schema_breadcrumbs(array $items): string
{
    $list = [];
    $pos = 1;
    foreach ($items as $label => $url) {
        $list[] = [
            '@type' => 'ListItem',
            'position' => $pos++,
            'name' => $label,
            'item' => dm_url($url),
        ];
    }
    return '<script type="application/ld+json">' . json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $list,
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
}

/** FAQ JSON-LD */
function dm_schema_faq(array $faqs): string
{
    $entities = [];
    foreach ($faqs as $f) {
        $entities[] = [
            '@type' => 'Question',
            'name' => $f['q'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
        ];
    }
    return '<script type="application/ld+json">' . json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $entities,
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
}

/** Physician JSON-LD */
function dm_schema_physician(array $doc): string
{
    $data = [
        '@context' => 'https://schema.org',
        '@type' => 'Physician',
        'name' => $doc['name'],
        'medicalSpecialty' => $doc['speciality'],
        'description' => $doc['intro'],
        'worksFor' => [
            '@type' => 'Hospital',
            'name' => 'Deccan Malti Neuro & Superspeciality Hospital',
            'address' => DM_ADDRESS,
        ],
    ];
    if (!empty($doc['qualifications'])) {
        $data['hasCredential'] = array_map(
            fn($q) => ['@type' => 'EducationalOccupationalCredential', 'credentialCategory' => $q],
            $doc['qualifications']
        );
    }
    return '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
}

/** Article JSON-LD */
function dm_schema_article(array $a, ?string $description = null): string
{
    $data = [
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => $a['title'],
        'description' => $description ?: $a['excerpt'],
        'image' => dm_url('assets/img/hospital-shoot/hospital-exterior-front.webp'),
        'datePublished' => $a['published'],
        'dateModified' => $a['updated'],
        'author' => ['@type' => 'Organization', 'name' => 'Deccan Malti Hospital'],
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'Deccan Malti Neuro & Superspeciality Hospital',
         'logo' => ['@type' => 'ImageObject', 'url' => dm_url('assets/img/brand-logo.png')],
        ],
    ];
    return '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
}
