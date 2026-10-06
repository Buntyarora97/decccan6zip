<?php
/**
 * Departments — Part 3: Oncology, Urology, Nephrology
 */
declare(strict_types=1);

return [

/* ============================================================ ONCOLOGY */
'oncology' => [
    'name'    => 'Oncology',
    'icon'    => 'ribbon',
    'group'   => 'medicine',
    'summary' => 'Cancer evaluation, diagnosis coordination and treatment support — with honest counselling and multi-speciality planning at every step.',
    'updated' => '2026-08-01',
    'overview' => 'The Oncology department at Deccan Malti Hospital, Sangli provides cancer evaluation, diagnostic coordination and treatment support for patients and families facing a possible or confirmed cancer diagnosis. Cancer care is a journey involving surgery, medicines and sometimes radiation — often across more than one speciality. This department\'s role is to make that journey organised and humane: correct diagnosis, honest explanation of options and stage, coordinated treatment planning, symptom support and follow-up, close to home wherever safely possible.',
    'help' => [
        'A suspected cancer diagnosis brings fear before facts. The first need is not treatment but clarity: is it cancer, what type, what stage, and what are the realistic options? This department exists to answer those questions methodically and compassionately, so that decisions are made on facts rather than fear.',
        'Cancer treatment today is rarely a single event. It is a sequence — biopsy and staging, then surgery, chemotherapy, radiation or targeted medicines in the combination appropriate to the specific cancer. Having a coordinating team that knows your case, arranges each step and watches the whole picture prevents the confusion and delays that fragmented care causes.',
        'Equally important is what honest oncology does not do: it does not promise cures it cannot deliver, and it does not hide difficult truths. You will be told what is known, what is uncertain, and what each option realistically offers — including the option, sometimes right, of comfort-focused care.',
    ],
    'conditions' => [
        ['name' => 'Breast Lumps & Breast Cancer', 'desc' => 'Evaluation of breast lumps with examination, imaging and biopsy. Confirmed cancers are staged and treated with surgery, medicines and radiation as appropriate — outcomes are best when caught early.', 'warning' => 'Any new breast lump, nipple discharge, skin dimpling or change needs prompt evaluation at any age.'],
        ['name' => 'Oral & Head-Neck Cancers', 'desc' => 'Ulcers, white or red patches, or lumps in the mouth and neck — strongly linked to tobacco in any form. Early evaluation of persistent mouth ulcers leads to early diagnosis.', 'warning' => 'A mouth ulcer not healing in 3 weeks, especially in a tobacco user, must be biopsied — do not wait.'],
        ['name' => 'Colorectal Cancer', 'desc' => 'Bleeding, changed bowel habits, anaemia or weight loss evaluated with colonoscopy and imaging. Treatment combines surgery with medicines based on stage.', 'warning' => 'Persistent change in bowel habit or bleeding after 45 needs colonoscopy evaluation.'],
        ['name' => 'Brain Tumours', 'desc' => 'Evaluated jointly with neurosurgery. After imaging and, where needed, biopsy or surgical removal, further treatment with radiation or medicines is coordinated as appropriate.', 'warning' => 'New persistent headaches with vomiting, seizures or one-sided weakness need prompt evaluation.'],
        ['name' => 'Blood Cancers', 'desc' => 'Leukaemias and lymphomas presenting as persistent fever, weight loss, lumps or abnormal blood counts are evaluated with marrow studies and specialised tests, with treatment coordinated with the appropriate centres.', 'warning' => 'Unexplained persistent fever, night sweats and weight loss together need investigation.'],
        ['name' => 'Palliative & Symptom Care', 'desc' => 'For advanced illness, care focuses on controlling pain and symptoms, supporting the family and preserving dignity — an active, valuable form of care, not "giving up".', 'warning' => 'Uncontrolled pain in advanced illness is treatable — ask for help rather than enduring it.'],
    ],
    'symptoms' => [
        'Any new lump — breast, neck, armpit, groin or elsewhere',
        'A mouth ulcer or patch not healing beyond three weeks',
        'Unexplained weight loss, persistent fever or night sweats',
        'Bleeding that is unusual — in stool, urine, between periods or after menopause',
        'A persistent change in bowel or bladder habits',
        'A cough or hoarseness persisting beyond three weeks',
        'Difficulty swallowing that is progressive',
    ],
    'urgent_note' => 'Most cancer symptoms need prompt — not emergency — evaluation. However, severe uncontrolled bleeding, breathlessness, confusion or uncontrolled pain in a known cancer patient need immediate medical attention.',
    'diagnostics' => [
        'Cancer diagnosis is built on proof, not suspicion. The sequence is: clinical examination, appropriate imaging — ultrasound, CT, MRI or mammography as the situation demands — and then tissue diagnosis through biopsy, because treatment cannot responsibly begin without it.',
        'Staging investigations determine how far disease has spread, which fundamentally shapes the treatment plan. Reports are discussed in person, with time for questions and family involvement.',
        'Second opinions on biopsy slides and scans are welcomed and facilitated — confident diagnosis is the foundation everything else rests on. Please confirm the availability of specific tests when booking.',
    ],
    'treatments' => [
        'Treatment is planned by stage and type, not by habit. Surgery where removal offers benefit; chemotherapy and targeted medicines where they improve outcomes; coordination with radiation oncology where radiation is part of the plan; and reconstruction with the plastic surgery team where cancer surgery leaves a significant defect.',
        'Supportive care runs alongside treatment: anti-sickness medicines, nutrition guidance, infection precautions during chemotherapy, and blood product support where needed.',
        'When cure is not realistically achievable, treatment goals are discussed honestly — control of disease, relief of symptoms, preservation of quality of life — so that care serves the patient\'s actual priorities.',
    ],
    'why' => [
        'Diagnosis-first discipline — treatment begins only on proven tissue diagnosis and staging',
        'Coordinated multi-speciality planning with surgery, neurosurgery and reconstruction',
        'Honest counselling — realistic outcomes explained, no false promises',
        'Care close to home wherever safely possible, reducing the burden of travel',
        'Symptom and palliative care treated as active, valuable care',
    ],
    'doctors' => [], // [VERIFY DOCTOR NAME] — oncologist details to be confirmed
    'pathway' => [
        ['t' => 'Evaluation', 'd' => 'History, examination and review of any existing reports.'],
        ['t' => 'Diagnosis & staging', 'd' => 'Biopsy and imaging to establish type and stage with certainty.'],
        ['t' => 'Tumour-board style planning', 'd' => 'Treatment sequence planned with the relevant specialities together.'],
        ['t' => 'Treatment', 'd' => 'Surgery, medicines and/or coordinated radiation, with supportive care.'],
        ['t' => 'Surveillance & support', 'd' => 'Structured follow-up, symptom management and family support.'],
    ],
    'preparation' => [
        'All previous reports — imaging, biopsy slides or blocks if available',
        'Discharge summaries and operative notes of any prior surgery',
        'A complete list of current medicines',
        'Family history of cancers — who, what type, at what age',
        'Insurance documents — cancer treatment should be financially planned early',
        'A family member for important discussions; bring your questions written down',
    ],
    'recovery' => [
        'Recovery after cancer surgery and during chemotherapy is gradual and individual. Nutrition, activity as tolerated, and attention to infection warning signs — especially fever during chemotherapy — form the backbone of safe recovery at home.',
        'Follow-up after cancer treatment continues for years on a defined schedule: examinations, blood tests and periodic scans to catch any recurrence early, when it is most treatable. Keeping these appointments is part of the treatment.',
        'Emotional recovery matters as much as physical. Fear of recurrence is normal; talking about it, and knowing your follow-up schedule is being kept, is the best antidote.',
    ],
    'faqs' => [
        ['q' => 'Does a biopsy make cancer spread?', 'a' => 'No. This is a persistent myth. Biopsy is the only reliable way to confirm cancer, and it does not cause spread. Delaying diagnosis out of this fear genuinely harms — early diagnosis is what improves outcomes.'],
        ['q' => 'Is cancer always fatal?', 'a' => 'No. Many cancers — early breast, oral, colorectal and several others — are curable, especially when caught early. Outcomes depend on type and stage, which is why prompt evaluation of warning symptoms matters so much.'],
        ['q' => 'Will chemotherapy definitely cause hair loss and vomiting?', 'a' => 'It depends on the specific medicines. Modern anti-sickness medication controls vomiting far better than in the past, and not all regimens cause complete hair loss. Your team will explain what your specific treatment involves before it starts.'],
        ['q' => 'Should the patient be told the diagnosis?', 'a' => 'In our view, yes — gently and honestly. Patients who know their diagnosis can participate in decisions, plan their affairs, and are spared the isolation of being the only one not told. How much detail, and when, is guided by the patient\'s own wishes.'],
        ['q' => 'Are there alternatives to chemotherapy that work?', 'a' => 'Treatment depends on cancer type and stage. Some cancers need surgery alone; others need medicines, radiation, or combinations. No proven alternative system replaces these — and delaying effective treatment for unproven remedies allows curable cancers to advance. Discuss all options openly with your oncologist.'],
        ['q' => 'Is cancer hereditary?', 'a' => 'Most cancers are not directly inherited, though some families carry higher risk — for example with breast and ovarian cancer. If several close relatives have had cancer, mention it at consultation; screening advice can be tailored.'],
        ['q' => 'Can treatment continue partly here and partly at a bigger centre?', 'a' => 'Yes, and this is often the sensible approach — specialised procedures at the appropriate centre, with chemotherapy administration, monitoring and follow-up coordinated locally to reduce travel. The plan is individualised.'],
        ['q' => 'What warning signs during chemotherapy need urgent attention?', 'a' => 'Fever of 100.4°F (38°C) or above, uncontrolled vomiting, breathlessness, bleeding, or confusion need immediate contact with the treating team or emergency care — do not wait for the next scheduled visit.'],
    ],
    'related'  => ['general-surgery', 'plastic-reconstructive-surgery', 'neurosurgery'],
    'articles' => ['cancer-warning-signs', 'diabetes-and-your-body'],
],

/* ============================================================ UROLOGY */
'urology' => [
    'name'    => 'Urology',
    'icon'    => 'urology',
    'group'   => 'surgical',
    'summary' => 'Kidney stones, prostate, urinary infections and bladder conditions — evaluated and treated with modern, minimally invasive approaches where suitable.',
    'updated' => '2026-08-01',
    'overview' => 'The Urology department treats conditions of the kidneys, ureters, bladder, prostate and male reproductive system. The commonest problems — kidney stones, enlarged prostate, urinary infections and blood in urine — are also the most neglected, often tolerated for years before consultation. At Deccan Malti Hospital, Sangli, urological care emphasises accurate diagnosis, medicines where they suffice, and endoscopic/minimally invasive procedures where an operation is genuinely needed, with clear explanation at every step.',
    'help' => [
        'Urinary symptoms intrude on life quietly but completely: waking three times a night to pass urine, the fear of travel because of urgency, the dread of another stone episode. These are treatable problems, and seeking care is straightforward — a consultation, a few focused tests, and a plan.',
        'Kidney stones deserve special mention in our region, where they are common. Treatment today is largely endoscopic — through natural passages, without cuts — and equally important is prevention: identifying why you form stones so the next one never forms.',
        'For elderly men, prostate enlargement is nearly universal with age, but suffering is not compulsory. Modern medicines help most; for those they do not, endoscopic surgery reliably restores comfortable urination.',
    ],
    'conditions' => [
        ['name' => 'Kidney & Ureteric Stones', 'desc' => 'Stones causing severe flank pain radiating to the groin, often with nausea or blood in urine. Small stones pass with medicines; larger or stuck stones are treated endoscopically or with laser fragmentation.', 'warning' => 'Stone pain with fever and chills is an emergency — an infected, blocked kidney can become dangerous quickly.'],
        ['name' => 'Enlarged Prostate (BPH)', 'desc' => 'Age-related prostate growth causing weak stream, straining, night-time urination and incomplete emptying. Managed with medicines initially; endoscopic surgery when medicines fail or complications develop.', 'warning' => 'Complete inability to pass urine is an emergency requiring catheterisation.'],
        ['name' => 'Urinary Tract Infections', 'desc' => 'Burning urination, frequency and lower abdominal discomfort. Recurrent or complicated infections — especially in men, children and diabetics — need proper evaluation for an underlying cause.', 'warning' => 'UTI with high fever, flank pain or confusion needs urgent treatment, particularly in the elderly.'],
        ['name' => 'Blood in Urine (Haematuria)', 'desc' => 'Visible blood in urine is never dismissed — evaluation with urine tests, imaging and cystoscopy rules out stones, infection and, importantly, bladder or kidney tumours.', 'warning' => 'Painless visible blood in urine after 40 needs full evaluation even if it happens only once.'],
        ['name' => 'Overactive Bladder & Incontinence', 'desc' => 'Urgency, frequency and leakage affecting daily life. Behavioural measures and medicines help most patients once the specific type is identified.', 'warning' => 'New incontinence with back pain or leg weakness needs urgent neurological evaluation.'],
        ['name' => 'Prostate Cancer Screening', 'desc' => 'PSA testing and examination for men over 50 or with family history, with honest counselling about what screening can and cannot tell, before any biopsy decision.', 'warning' => 'A rising PSA or hard prostate on examination needs specialist evaluation.'],
    ],
    'symptoms' => [
        'Severe flank or abdominal pain coming in waves',
        'Burning or pain while passing urine',
        'Blood in urine — visible or detected on testing',
        'Weak urine stream, straining, or feeling of incomplete emptying',
        'Waking repeatedly at night to pass urine',
        'Urgency or leakage affecting daily activities',
        'Recurrent urinary infections',
    ],
    'urgent_note' => 'Complete inability to pass urine, stone pain with high fever and chills, or heavy visible blood in urine with clots need urgent medical attention — do not wait for a routine appointment.',
    'diagnostics' => [
        'Evaluation starts with history and examination, including prostate examination where relevant. Urine tests identify infection and blood; blood tests assess kidney function and, where indicated, PSA.',
        'Ultrasound is the standard first imaging for stones, prostate size and bladder emptying; CT scanning defines stones precisely when treatment is planned. Uroflowmetry measures the urine stream objectively in prostate problems, and cystoscopy — camera inspection of the bladder — is advised for blood in urine or suspected bladder lesions. Please confirm the availability of specific tests when booking.',
        'For stone formers, metabolic evaluation — stone analysis and targeted blood and urine tests — identifies preventable causes.',
    ],
    'treatments' => [
        'Medicines come first where they work: alpha-blockers for prostate symptoms and small ureteric stones, antibiotics guided by culture for infections, and behavioural plus medical therapy for overactive bladder.',
        'When procedures are needed, modern urology is largely endoscopic: ureteroscopy and laser fragmentation for stones, endoscopic prostate surgery for obstruction, and cystoscopic procedures for bladder conditions — all through natural passages, without external cuts, and with short hospital stays.',
        'Stone prevention is prescribed as seriously as stone treatment: fluid targets, dietary modification and, where tests indicate, preventive medication — because the best stone procedure is the one that never becomes necessary.',
    ],
    'why' => [
        'Minimally invasive, endoscopy-first approach for stones and prostate',
        'Stone prevention programmes, not just stone removal',
        'Respectful, unembarrassed consultation for intimate symptoms',
        'Thorough evaluation of blood in urine — reassurance backed by proper testing',
        'Coordination with nephrology for patients with kidney function concerns',
    ],
    'doctors' => [], // [VERIFY DOCTOR NAME] — urologist details to be confirmed
    'pathway' => [
        ['t' => 'Consultation', 'd' => 'Symptoms, examination and review of previous reports.'],
        ['t' => 'Focused testing', 'd' => 'Urine and blood tests, ultrasound, flow study or CT as indicated.'],
        ['t' => 'Medical management', 'd' => 'Medicines and lifestyle measures tried first where appropriate.'],
        ['t' => 'Endoscopic procedure', 'd' => 'When needed — laser stone treatment or prostate surgery, short stay.'],
        ['t' => 'Prevention & follow-up', 'd' => 'Stone-prevention plan or symptom review at defined intervals.'],
    ],
    'preparation' => [
        'Previous ultrasound, CT reports and any stone analyses',
        'Urine test and culture reports, especially for recurrent infections',
        'Current medicine list, including blood thinners',
        'A voiding diary (times and volumes) if you have frequency or incontinence',
        'Recent kidney function reports',
        'Insurance documents for planned procedures',
    ],
    'recovery' => [
        'Recovery after endoscopic stone or prostate surgery is typically quick — most patients are up the same day and home in one to two days. A temporary stent may be placed after stone surgery; its removal date will be clearly scheduled — do not miss it.',
        'Drinking enough fluid to keep urine pale is the single most important long-term instruction after stones. Specific dietary guidance follows your stone analysis.',
        'Report fever, inability to pass urine, or worsening bleeding promptly after any urological procedure rather than waiting for the scheduled review.',
    ],
    'faqs' => [
        ['q' => 'Do all kidney stones need surgery?', 'a' => 'No. Small stones — typically under 5–6 mm — often pass on their own with medicines and hydration. Surgery is needed for stones that are too large, stuck, causing infection, or damaging kidney function.'],
        ['q' => 'Why do my stones keep coming back?', 'a' => 'Recurrent stones usually have an identifiable cause — low fluid intake, dietary factors or a metabolic tendency. Stone analysis and metabolic testing identify the cause, and targeted prevention cuts recurrence substantially.'],
        ['q' => 'Is an enlarged prostate cancer?', 'a' => 'No. Benign prostatic enlargement (BPH) is age-related growth and is not cancer. However, symptoms overlap with prostate cancer, which is why evaluation — including examination and PSA where appropriate — matters before starting treatment.'],
        ['q' => 'Will prostate surgery affect my sexual function?', 'a' => 'Endoscopic prostate surgery for BPH commonly causes retrograde ejaculation (semen going into the bladder) but usually preserves erections. Effects vary by procedure and individual; discuss this openly with your surgeon beforehand.'],
        ['q' => 'I saw blood in my urine once, then it stopped. Should I still get checked?', 'a' => 'Yes. Painless blood in urine that stops on its own still needs evaluation — stones, infection and bladder tumours can all bleed intermittently. One episode after 40 justifies a full check.'],
        ['q' => 'How much water should a stone former drink?', 'a' => 'Enough to produce roughly 2–2.5 litres of urine daily — in practice, fluid intake spread across the day such that urine stays pale yellow. In hot weather or physical work, more is needed.'],
        ['q' => 'Are urinary infections in men a concern?', 'a' => 'Yes. UTIs are far less common in men, so when they occur they usually signal an underlying issue — an enlarged prostate, stones or poor bladder emptying — which itself needs evaluation and treatment.'],
        ['q' => 'What is a DJ stent and why must it be removed on time?', 'a' => 'A DJ stent is a thin tube temporarily placed between kidney and bladder after stone surgery to keep the passage open while it heals. It causes mild urinary symptoms but must be removed on schedule — forgotten stents can become encrusted and difficult to remove.'],
    ],
    'related'  => ['nephrology', 'general-surgery', 'oncology'],
    'articles' => ['kidney-stones-guide', 'diabetes-and-your-body'],
],

/* ============================================================ NEPHROLOGY */
'nephrology' => [
    'name'    => 'Nephrology',
    'icon'    => 'kidney',
    'group'   => 'medicine',
    'summary' => 'Kidney care — chronic kidney disease, diabetic kidney protection, blood pressure-related kidney damage and dialysis guidance.',
    'updated' => '2026-08-01',
    'overview' => 'The Nephrology department cares for patients with kidney disease — from early protein leakage in diabetics to advanced chronic kidney disease requiring dialysis planning. Kidney disease is silent until late, which makes early detection in high-risk people — diabetics, hypertensives, those with family history — the department\'s central mission. At Deccan Malti Hospital, Sangli, care focuses on slowing progression with proven measures, preparing patients and families properly when dialysis becomes necessary, and coordinating with cardiology and urology for the whole-person care kidney patients need.',
    'help' => [
        'Kidneys fail quietly. By the time symptoms appear — swelling, breathlessness, nausea, fatigue — significant function has usually been lost. This is why nephrology places such weight on the simple tests that detect trouble years earlier: urine protein and blood creatinine. If you have diabetes or high blood pressure, these tests are as important as your sugar and BP readings.',
        'A diagnosis of chronic kidney disease is not a sentence to dialysis. With blood pressure control, sugar discipline, kidney-protective medicines where indicated, and avoidance of kidney-harming painkillers, progression can often be slowed dramatically. The earlier this starts, the more kidney function is preserved.',
        'When dialysis does become necessary, preparation matters: timely planning of access, vaccination, and family counselling make the difference between a planned, calm start and an emergency one.',
    ],
    'conditions' => [
        ['name' => 'Chronic Kidney Disease (CKD)', 'desc' => 'Gradual, permanent loss of kidney function, most often from diabetes and hypertension. Staged 1–5 by eGFR; early stages are managed medically to slow progression, later stages need preparation for replacement therapy.', 'warning' => 'Known CKD with worsening breathlessness, swelling or vomiting needs prompt review, not a routine wait.'],
        ['name' => 'Diabetic Kidney Disease', 'desc' => 'Kidney damage from years of diabetes, beginning silently as protein in urine. Early detection plus sugar, BP and specific kidney-protective medicines can markedly slow decline.', 'warning' => 'Every diabetic should have urine protein and creatinine checked at least yearly — even when feeling perfectly well.'],
        ['name' => 'Hypertensive Kidney Damage', 'desc' => 'Long-standing high blood pressure scars the kidneys, and damaged kidneys raise BP further — a cycle that treatment must break with consistent BP control.', 'warning' => 'BP that remains high despite three medicines needs evaluation for a kidney or other secondary cause.'],
        ['name' => 'Acute Kidney Injury', 'desc' => 'Sudden kidney shutdown from dehydration, infection, medicines or obstruction. Often reversible with prompt treatment — which is why sudden reduced urine output is never ignored.', 'warning' => 'Markedly reduced urine output, especially with vomiting, diarrhoea or after new medicines, needs same-day assessment.'],
        ['name' => 'Kidney Stones & Kidney Health', 'desc' => 'Recurrent stones, especially with infection or obstruction, can damage kidneys over time. Management with urology focuses on clearance and prevention.', 'warning' => 'Stone with fever is dangerous for the kidney — treat as urgent.'],
        ['name' => 'Dialysis Planning & Follow-up', 'desc' => 'When kidney function falls to levels needing replacement, options — haemodialysis, peritoneal dialysis, transplant evaluation — are explained early, access is planned, and ongoing care is coordinated.', 'warning' => 'Missed dialysis sessions with breathlessness or chest symptoms need urgent attention.'],
    ],
    'symptoms' => [
        'Swelling of feet, ankles or around the eyes — especially in the morning',
        'Foamy or frothy urine persisting over days',
        'Reduced urine output',
        'Unexplained fatigue, nausea or loss of appetite',
        'High blood pressure that is difficult to control',
        'You have diabetes or hypertension — get screened even without symptoms',
        'Muscle cramps or persistent itching without skin cause',
    ],
    'urgent_note' => 'Sudden marked reduction in urine output, breathlessness with leg swelling, or confusion in a known kidney patient need same-day medical assessment. Dialysis patients who miss sessions and develop breathlessness should seek urgent care.',
    'diagnostics' => [
        'Kidney evaluation rests on simple, powerful tests: blood creatinine (from which eGFR — the kidney function percentage — is calculated), urine examination and urine protein measurement, and blood pressure readings. Ultrasound assesses kidney size, obstruction and stones.',
        'For unclear or rapidly progressing disease, further blood tests and occasionally kidney biopsy are needed; the reasons and process are explained in detail beforehand. Please confirm the availability of specific tests when booking.',
        'Monitoring is structured: stable early CKD needs checks every few months; advancing disease needs them more often. A personal schedule is given, not a vague "come when needed".',
    ],
    'treatments' => [
        'Early and middle-stage CKD treatment targets the drivers: rigorous blood pressure control, sugar control in diabetics, kidney-protective medicines where indicated, dietary salt and protein guidance, and strict avoidance of over-the-counter painkillers (NSAIDs) and unverified remedies that silently harm kidneys.',
        'Complications are treated as they arise: anaemia of kidney disease, mineral and bone disorder, and acid load each have specific treatments that improve how patients feel and function.',
        'For advanced disease, the focus shifts to preparation: dialysis access planned before it is urgently needed, vaccinations completed, and transplant evaluation discussed where appropriate — so that replacement therapy begins as a planned transition, not a crisis.',
    ],
    'why' => [
        'Early-detection focus — screening diabetics and hypertensives before symptoms appear',
        'Progression-slowing treatment built on proven measures, not promises',
        'Structured monitoring schedules, so changes are caught between visits',
        'Calm, planned dialysis preparation instead of emergency starts',
        'Coordination with cardiology, urology and diabetology for whole-patient care',
    ],
    'doctors' => [], // [VERIFY DOCTOR NAME] — nephrologist details to be confirmed
    'pathway' => [
        ['t' => 'Screening or consultation', 'd' => 'History, examination, BP and baseline kidney tests.'],
        ['t' => 'Staging & cause', 'd' => 'eGFR, urine protein and ultrasound define the stage and likely cause.'],
        ['t' => 'Progression plan', 'd' => 'BP, sugar, medicines, diet and painkiller avoidance — with written targets.'],
        ['t' => 'Structured monitoring', 'd' => 'Review schedule matched to your stage; treatment adjusted on trends.'],
        ['t' => 'Replacement planning', 'd' => 'If function declines: access, vaccination and modality counselling in advance.'],
    ],
    'preparation' => [
        'All previous creatinine, eGFR and urine reports — trends matter enormously',
        'Recent sugar and HbA1c reports if diabetic',
        'Home blood pressure diary, if you keep one',
        'Complete medicine list, including any painkillers or supplements',
        'Ultrasound or scan reports of the kidneys',
        'Insurance documents — kidney care is long-term and should be financially planned',
    ],
    'recovery' => [
        'Chronic kidney disease is managed, not cured — which makes daily habits the real treatment: salt restriction, prescribed fluid and diet guidance, medicines without gaps, and no self-medication with painkillers or herbal remedies of unknown safety.',
        'For dialysis patients, routine is safety: sessions attended as scheduled, fluid limits kept between sessions, access-site care, and prompt reporting of fever, breathlessness or access problems.',
        'Family involvement improves outcomes — families are counselled on diet support, medicine schedules and the warning signs that need early contact.',
    ],
    'faqs' => [
        ['q' => 'My creatinine is slightly high but I feel fine. Does it matter?', 'a' => 'Yes — this is exactly when it matters most. Kidney disease causes no symptoms until advanced stages. A raised creatinine found early, with treatment started early, can preserve kidney function for years. "Feeling fine" is not reassurance with kidneys.'],
        ['q' => 'Does every CKD patient eventually need dialysis?', 'a' => 'No. Many patients, especially those detected early, stabilise or decline so slowly with proper treatment that dialysis is never needed. The stage at detection and how well BP, sugar and diet are controlled largely determine the course.'],
        ['q' => 'Are painkillers really harmful to kidneys?', 'a' => 'Yes. Regular use of common painkillers like diclofenac, ibuprofen and similar drugs damages kidneys, especially in people who already have reduced function, diabetes or hypertension. Kidney patients should take painkillers only on medical advice.'],
        ['q' => 'How often should a diabetic test kidney function?', 'a' => 'At least once a year — urine albumin and blood creatinine — even with normal previous results and no symptoms. More often if either test is abnormal or sugar control has been poor.'],
        ['q' => 'What diet should a kidney patient follow?', 'a' => 'The core principles: restrict salt strictly, moderate protein as advised for your stage, limit high-potassium and high-phosphate foods if your levels are raised, and follow fluid guidance if prescribed. Diet in kidney disease is stage-specific — follow the plan given for your stage, not generic internet advice.'],
        ['q' => 'Is dialysis permanent once started?', 'a' => 'For chronic kidney disease reaching stage 5, dialysis is usually long-term unless a transplant is performed. For acute kidney injury — sudden shutdown from dehydration, infection or medicines — dialysis may be temporary support until kidneys recover. The two situations are very different.'],
        ['q' => 'Can Ayurvedic or herbal medicines treat kidney disease?', 'a' => 'Unverified remedies are risky in kidney disease — some are directly kidney-toxic, and relying on them delays proven treatment. If you wish to use any supplement, show it to your nephrologist first. Proven progression-slowing treatment exists; do not trade it for promises.'],
        ['q' => 'What is eGFR and what number should I worry about?', 'a' => 'eGFR estimates what percentage of normal kidney function you have. Above 90 is normal; 60–89 is watched; below 60 persisting for three months defines CKD; below 30 needs close nephrology care and forward planning. One abnormal value is always rechecked before conclusions.'],
    ],
    'related'  => ['urology', 'cardiology', 'neurology'],
    'articles' => ['kidney-stones-guide', 'diabetes-and-your-body'],
],

];
