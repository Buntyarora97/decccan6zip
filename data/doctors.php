<?php
/**
 * Doctors directory — SIRF verified profiles publish karein.
 * Naye doctor ka approved data + portrait milne par hi entry add karein.
 * Registration numbers, awards, memberships tabhi add karein jab written evidence ho.
 */
declare(strict_types=1);

function dm_doctors(): array
{
    return [
        'dr-p-c-patil' => [
            'name'       => 'Dr. P. C. Patil',
            'speciality' => 'General Surgery',
            'role'       => 'Co-Founder & General Surgeon',
            'qualifications' => ['General Surgeon'], // [VERIFY] degree details e.g. MS (Gen. Surgery)
            'experience' => 'More than 35 years of surgical experience',
            'languages'  => '', // [VERIFY] e.g. Marathi, Hindi, English
            'image'      => 'assets/img/real/dr-p-c-patil.webp',
            'image_alt'  => 'Dr. P. C. Patil, Co-Founder and General Surgeon at Deccan Malti Hospital, Sangli',
            'published'  => true,
            'intro'      => 'Dr. P. C. Patil is a general surgeon and co-founder of Deccan Malti Neuro & Superspeciality Hospital, Sangli, with more than 35 years of experience in surgical practice.',
            'bio'        => [
                'Dr. P. C. Patil is a co-founder of Deccan Malti Neuro & Superspeciality Hospital, Vishrambag, Sangli. With more than 35 years of experience in general surgery, he has guided the hospital\'s clinical culture from its launch in March 2023 — with a strong emphasis on careful evaluation, honest counselling and safe surgical practice.',
                'Patients value his unhurried consultations: he listens to the full history, explains the diagnosis and the options in simple language, and recommends surgery only when it is genuinely indicated. When non-surgical management is appropriate, he says so clearly.',
                'At Deccan Malti Hospital, he leads general surgical care and works closely with the neurosurgery, orthopaedic, oncology and other speciality teams so that patients who need multi-speciality input receive it in a coordinated way.',
            ],
            'interests'  => [
                'General and abdominal surgical evaluation',
                'Hernia, gallbladder and appendix conditions',
                'Minor and day-care surgical procedures',
                'Pre-operative assessment and post-operative care',
            ],
            'memberships' => [], // [VERIFY] add only with evidence
            'awards'      => [], // [VERIFY]
            'timings'     => 'Consultation timings are confirmed at the time of appointment booking. Please call ' . DM_PHONE_DISPLAY . '.',
            'faqs' => [
                ['q' => 'How do I book a consultation with Dr. P. C. Patil?', 'a' => 'You can request an appointment through the website form, call +91 883 000 6879, or message the hospital on WhatsApp. The front desk will confirm a suitable slot after checking the doctor\'s schedule.'],
                ['q' => 'What should I bring to my first surgical consultation?', 'a' => 'Please bring any previous consultation notes, investigation reports, scans, a list of medicines you currently take, and your insurance documents if you plan to use insurance.'],
                ['q' => 'Will I definitely need surgery if I consult a surgeon?', 'a' => 'No. A surgical consultation is an evaluation. Many conditions are managed with medicines, lifestyle measures or observation. Surgery is advised only when clinically indicated, and the decision is always made together with you after explaining the options.'],
            ],
        ],

        'dr-rohan-patil' => [
            'name'       => 'Dr. Rohan Patil',
            'speciality' => 'Neurosurgery',
            'role'       => 'Co-Founder & Neurosurgeon',
            'qualifications' => ['MS', 'M.Ch (Neurosurgery)'],
            'experience' => 'More than 10 years of experience in neurosurgery',
            'languages'  => '', // [VERIFY]
            'image'      => 'assets/img/real/dr-rohan-patil.webp',
            'image_alt'  => 'Dr. Rohan Patil, Co-Founder and Neurosurgeon at Deccan Malti Hospital, Sangli',
            'published'  => true,
            'intro'      => 'Dr. Rohan Patil is a neurosurgeon (MS, M.Ch in Neurosurgery) and co-founder of Deccan Malti Neuro & Superspeciality Hospital, Sangli, with more than 10 years of experience.',
            'bio'        => [
                'Dr. Rohan Patil, MS, M.Ch (Neurosurgery), is a co-founder of Deccan Malti Neuro & Superspeciality Hospital and leads its neurosurgical services. He has more than 10 years of experience in the evaluation and surgical management of brain and spine conditions.',
                'His approach combines modern neurosurgical training with a strong belief that patients and families must understand a condition before agreeing to treatment. Consultations focus on explaining imaging findings, the natural course of the condition, and the realistic benefits and risks of each option.',
                'He established the hospital in Sangli so that patients from Sangli district and nearby regions can access specialist brain and spine care close to home, with coordinated support from neurology, critical care and rehabilitation services.',
            ],
            'interests'  => [
                'Brain tumour and skull-base evaluation',
                'Spine surgery — disc, stenosis and instability',
                'Head injury and neuro-trauma care',
                'Cerebrovascular surgical evaluation',
            ],
            'memberships' => [], // [VERIFY]
            'awards'      => [], // [VERIFY]
            'timings'     => 'Consultation timings are confirmed at the time of appointment booking. Please call ' . DM_PHONE_DISPLAY . '.',
            'faqs' => [
                ['q' => 'Do all brain or spine problems need surgery?', 'a' => 'No. Many neurological and spine conditions improve with medicines, physiotherapy and lifestyle changes. Surgery is recommended only when it offers a clear benefit — for example, progressive weakness, severe nerve compression or certain tumours — and always after discussing alternatives with you.'],
                ['q' => 'Should I bring my MRI or CT scan to the consultation?', 'a' => 'Yes. Please bring all previous scans (films or CD/report), consultation notes and a list of your current medicines. If you do not have scans, the doctor will advise whether any are needed.'],
                ['q' => 'How do I book a neurosurgery consultation with Dr. Rohan Patil?', 'a' => 'You can request an appointment online, call +91 883 000 6879, or message on WhatsApp. The team will confirm your slot after checking the doctor\'s schedule.'],
                ['q' => 'What symptoms should prompt an urgent neurosurgical opinion?', 'a' => 'Sudden severe headache, one-sided weakness, slurred speech, loss of consciousness, new seizures, or rapidly worsening back pain with leg weakness or loss of bladder/bowel control need urgent evaluation. In such situations, go to the nearest emergency facility immediately.'],
            ],
        ],

        /* ---------- Template for future approved doctors (unpublished) ----------
        'dr-example' => [
            'name' => '[VERIFY DOCTOR NAME]',
            'speciality' => '[VERIFY SPECIALITY]',
            'role' => '[VERIFY ROLE]',
            'qualifications' => [], // [VERIFY]
            'experience' => '[VERIFY EXPERIENCE STATEMENT]',
            'languages' => '',
           'image_alt' => 'Deccan Malti Hospital welcome display — approved doctor portrait pending',
            'published' => false, // true karne se pehle: approved portrait + verified credentials
            'intro' => '',
            'bio' => [],
            'interests' => [],
            'memberships' => [],
            'awards' => [],
            'timings' => '',
            'faqs' => [],
        ],
        --------------------------------------------------------------------------- */
    ];
}
