<?php
/**
 * Public service catalogue. Descriptions explain a service generally and avoid
 * claims about individual clinicians, treatment outcomes or unverified capability.
 */
return [
    'clinical' => [
        'label' => 'Clinical Services',
        'icon' => 'stetho',
        'groups' => [
            'Super Specialities' => [
                ['id' => 'neurosurgery', 'name' => 'Neurosurgery', 'icon' => 'brain', 'department' => 'neurosurgery', 'summary' => 'Specialist assessment of conditions affecting the brain, spine and nervous system.'],
                ['id' => 'plastic-reconstructive-surgery', 'name' => 'Plastic & Reconstructive Surgery', 'icon' => 'hand', 'department' => 'plastic-reconstructive-surgery', 'summary' => 'Consultation for reconstructive and restorative care related to injury, illness or other conditions.'],
                ['id' => 'colorectal-surgery', 'name' => 'Colorectal Surgery', 'icon' => 'activity', 'department' => 'colorectal-surgery', 'summary' => 'Evaluation of conditions involving the colon, rectum and related structures.'],
                ['id' => 'anorectal-surgery', 'name' => 'Anorectal Surgery', 'icon' => 'activity', 'summary' => 'Specialist assessment of conditions affecting the anal and rectal area.'],
                ['id' => 'joint-replacement', 'name' => 'Joint Replacement', 'icon' => 'bone', 'department' => 'orthopaedics-joint-replacement', 'summary' => 'Evaluation of joint pain and mobility concerns, including discussion of treatment options.'],
                ['id' => 'neurology', 'name' => 'Neurology', 'icon' => 'brain', 'department' => 'neurology', 'summary' => 'Assessment of conditions affecting the brain, spinal cord, nerves and muscles.'],
                ['id' => 'urology', 'name' => 'Urology', 'icon' => 'activity', 'department' => 'urology', 'summary' => 'Consultation for conditions involving the urinary system and related concerns.'],
                ['id' => 'oncology', 'name' => 'Oncology', 'icon' => 'ribbon', 'department' => 'oncology', 'summary' => 'Medical consultation and guidance for people facing a cancer diagnosis or concern.'],
                ['id' => 'nephrology', 'name' => 'Nephrology', 'icon' => 'activity', 'department' => 'nephrology', 'summary' => 'Assessment and medical care for kidney-related conditions.'],
            ],
            'Other Specialities' => [
                ['id' => 'cardiology', 'name' => 'Cardiology', 'icon' => 'heart', 'department' => 'cardiology', 'summary' => 'Evaluation of symptoms and conditions involving the heart and circulation.'],
                ['id' => 'general-medicine', 'name' => 'General Medicine', 'icon' => 'stetho', 'summary' => 'First medical assessment for common health concerns and ongoing conditions.'],
                ['id' => 'general-surgery', 'name' => 'General Surgery', 'icon' => 'activity', 'department' => 'general-surgery', 'summary' => 'Surgical consultation to assess a concern and explain appropriate care options.'],
                ['id' => 'laparoscopic-surgery', 'name' => 'Laparoscopic Surgery', 'icon' => 'activity', 'summary' => 'Consultation about minimally invasive surgical approaches where clinically appropriate.'],
                ['id' => 'orthopaedics', 'name' => 'Orthopaedics', 'icon' => 'bone', 'summary' => 'Assessment of bone, joint and movement-related concerns.'],
            ],
        ],
    ],
    'diagnostic' => [
        'label' => 'Diagnostic Services',
        'icon' => 'search',
        'groups' => [
            'Diagnostic Services' => [
                ['id' => 'radiology', 'name' => 'Radiology', 'icon' => 'scan', 'summary' => 'Medical imaging can help clinicians assess and monitor a range of conditions.'],
                ['id' => 'ct-scan', 'name' => 'CT Scan', 'icon' => 'scan', 'summary' => 'Computed tomography creates cross-sectional images to support clinical evaluation.'],
                ['id' => 'digital-x-ray', 'name' => 'Digital X-Ray', 'icon' => 'scan', 'summary' => 'X-ray imaging supports assessment of selected bones and body areas.'],
                ['id' => 'eeg', 'name' => 'EEG', 'icon' => 'pulse', 'summary' => 'An electroencephalogram records electrical activity in the brain for clinical assessment.'],
                ['id' => 'ncv', 'name' => 'NCV', 'icon' => 'pulse', 'summary' => 'A nerve conduction study measures how signals travel through selected peripheral nerves.'],
                ['id' => 'pathology-laboratory', 'name' => 'Pathology & Laboratory Services', 'icon' => 'flask', 'summary' => 'Laboratory investigations provide information that clinicians consider alongside symptoms and examination.'],
            ],
        ],
    ],
    'allied' => [
        'label' => 'Allied & Supportive Services',
        'icon' => 'hand',
        'groups' => [
            'Allied & Supportive Services' => [
                ['id' => 'pharmacy', 'name' => 'Pharmacy', 'icon' => 'pill', 'summary' => 'The hospital pharmacy supports patients with prescribed medicines; pharmacy service is listed as 24/7.'],
                ['id' => 'physiotherapy-rehabilitation', 'name' => 'Physiotherapy & Rehabilitation Centre', 'icon' => 'activity', 'summary' => 'Physiotherapy and rehabilitation support movement, function and recovery goals.'],
                ['id' => 'ambulance-service', 'name' => 'Ambulance Service', 'icon' => 'ambulance', 'summary' => 'For ambulance enquiries, contact the hospital to confirm current arrangements and availability.'],
            ],
        ],
    ],
];
