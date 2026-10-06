<?php
/**
 * Confirmed facility categories and factual, non-promissory descriptions.
 * No room capacity or availability figures are published here.
 */
return [
    'critical_care' => [
        ['id' => 'casualty-emergency', 'name' => 'Casualty / Emergency Care', 'icon' => 'alert', 'summary' => 'Emergency care for urgent medical concerns. For a life-threatening emergency, call local emergency services or go to the nearest emergency facility.'],
        ['id' => 'icu', 'name' => 'Intensive Care Unit (ICU)', 'icon' => 'pulse', 'summary' => 'Intensive care for patients who need closer medical monitoring, as determined by the treating team.'],
        ['id' => 'hdu', 'name' => 'High Dependency Unit (HDU)', 'icon' => 'activity', 'summary' => 'Higher-dependency care for patients who require closer observation; suitability is determined by the clinical team.'],
    ],
    'rooms' => [
        ['id' => 'male-general-ward', 'name' => 'General Ward — Male', 'icon' => 'bed', 'summary' => 'General inpatient accommodation for male patients. Ask the hospital team about current availability.'],
        ['id' => 'female-general-ward', 'name' => 'General Ward — Female', 'icon' => 'bed', 'summary' => 'General inpatient accommodation for female patients. Ask the hospital team about current availability.'],
        ['id' => 'ac-single-deluxe', 'name' => 'AC Single / Deluxe Room', 'icon' => 'building', 'summary' => 'Air-conditioned single-room category. Confirm the room category and current availability with the hospital.'],
        ['id' => 'non-ac-single-deluxe', 'name' => 'Non-AC Single / Deluxe Room', 'icon' => 'building', 'summary' => 'Non-air-conditioned single-room category. Confirm the room category and current availability with the hospital.'],
        ['id' => 'suite-room', 'name' => 'Suite Room', 'icon' => 'star', 'summary' => 'Suite room category. Ask the hospital team about details and current availability.'],
    ],
    'infrastructure' => [
        ['id' => 'modular-operation-theatre', 'name' => 'Modular Operation Theatre', 'icon' => 'activity', 'summary' => 'Modular OT with air-filtration infrastructure.'],
        ['id' => 'pentero-surgical-microscope', 'name' => 'Pentero Surgical Microscope', 'icon' => 'scan', 'summary' => 'Surgical microscope that supports magnified visualisation during selected procedures.'],
        ['id' => 'cusa-technology', 'name' => 'CUSA Technology', 'icon' => 'pulse', 'summary' => 'Cavitron Ultrasonic Surgical Aspirator technology; suitability is determined by the treating specialist.'],
        ['id' => 'in-house-ct-scan', 'name' => 'In-house CT Scan', 'icon' => 'scan', 'summary' => 'CT scan available within the hospital; imaging is advised based on clinical assessment.'],
        ['id' => 'pathology-lab', 'name' => 'Pathology & Laboratory Services', 'icon' => 'flask', 'summary' => 'Laboratory investigations that clinicians may use to support assessment and care.'],
        ['id' => '24-7-pharmacy', 'name' => '24/7 Pharmacy', 'icon' => 'pill', 'summary' => 'Hospital pharmacy service listed as available 24 hours a day.'],
        ['id' => 'physiotherapy-rehabilitation', 'name' => 'Physiotherapy & Rehabilitation', 'icon' => 'activity', 'summary' => 'Department for physiotherapy and rehabilitation support.'],
        ['id' => 'cashless-insurance-assistance', 'name' => 'Cashless Insurance Assistance', 'icon' => 'shield', 'summary' => 'Help with policy-specific enquiries and the cashless process; eligibility and approvals depend on the insurer.'],
        ['id' => 'cmrf-guidance', 'name' => 'Chief Minister’s Relief Fund (CMRF) Guidance', 'icon' => 'hand', 'summary' => 'Guidance and support for enquiries; eligibility and financial assistance are subject to programme rules and approval.'],
    ],
];
