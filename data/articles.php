<?php
/**
 * Health Library articles — educational content, medically responsible.
 * Articles show their publishing organisation and dates; only display medical-review credits after verification.
 */
declare(strict_types=1);

function dm_articles(): array
{
    return [
        'stroke-warning-signs' => [
            'title'    => 'Stroke: Warning Signs Every Family Should Recognise',
            'category' => 'Brain & Nerves',
            'excerpt'  => 'Stroke treatment is a race against time. Learn the FAST warning signs and what to do in the first minutes.',
            'published'=> '2026-07-15',
            'updated'  => '2026-08-01',
            'readtime' => '5 min read',
            'author'   => 'Deccan Malti Hospital',
            'reviewer' => '',
            'body'     => [
                ['h' => 'Why minutes matter', 'p' => 'A stroke occurs when blood supply to part of the brain is blocked or a vessel bursts. Brain cells begin to die within minutes, which is why stroke is treated as one of the most time-sensitive emergencies in medicine. Treatments that can limit damage are available, but only within a narrow window from the time symptoms begin — and only if the patient reaches an appropriate facility in time.'],
                ['h' => 'The FAST check', 'p' => 'Remember the word FAST. F — Face: ask the person to smile; does one side droop? A — Arms: ask them to raise both arms; does one drift down? S — Speech: is speech slurred or strange? T — Time: if any of these are present, call for emergency help immediately and note the time symptoms started. Other warning signs include sudden vision loss, sudden severe headache, sudden loss of balance, or sudden confusion.'],
                ['h' => 'What to do — and what not to do', 'p' => 'Do call for emergency help or arrange immediate transport to the nearest emergency facility. Do note the exact time symptoms began — this determines which treatments are possible. Do not give food, water or medicines by mouth, as swallowing may be unsafe. Do not wait to see if symptoms improve; even symptoms that resolve on their own (a TIA or "mini-stroke") are a serious warning needing urgent evaluation.'],
                ['h' => 'Prevention after a stroke', 'p' => 'After a stroke or TIA, the focus shifts to preventing the next one: controlling blood pressure, sugar and cholesterol, stopping tobacco, taking prescribed blood-thinning or other medicines without gaps, and attending follow-up. Most recurrent strokes are preventable with consistent risk-factor control.'],
                ['h' => 'The bottom line', 'p' => 'Stroke is common, sudden and time-critical. Every family should know FAST. When in doubt, treat it as a stroke and seek emergency care — a false alarm costs nothing compared to the cost of delay.'],
            ],
        ],

        'understanding-back-pain' => [
            'title'    => 'Back Pain: When Is It Serious, and When Will It Pass?',
            'category' => 'Spine & Joints',
            'excerpt'  => 'Most back pain heals on its own — but some warning signs should never be ignored. A practical guide.',
            'published'=> '2026-07-20',
            'updated'  => '2026-08-01',
            'readtime' => '6 min read',
            'author'   => 'Deccan Malti Hospital',
            'reviewer' => '',
            'body'     => [
                ['h' => 'The reassuring truth first', 'p' => 'Most episodes of back pain — the kind that follows lifting, a long journey or an awkward twist — are mechanical and improve within days to a few weeks. Bed rest beyond a day or two actually delays recovery; gentle activity, simple pain relief and time do most of the work. Scans are usually unnecessary in the first weeks unless warning signs are present.'],
                ['h' => 'Warning signs that need prompt evaluation', 'p' => 'Certain features change the picture completely: back pain with leg weakness or numbness spreading down the leg; loss of bladder or bowel control or numbness in the inner thighs (an emergency); pain after significant injury; pain with fever or unexplained weight loss; night pain that is unrelenting; or pain in someone with a history of cancer. These need prompt medical evaluation, not home remedies.'],
                ['h' => 'What actually helps', 'p' => 'For ordinary back pain: stay active within comfort, use heat or simple prescribed pain relief, avoid prolonged sitting, and begin gentle stretching as pain settles. For prevention: strengthen your core, lift with bent knees, watch your weight, and set up your work position sensibly. Physiotherapy helps when pain persists beyond a few weeks.'],
                ['h' => 'Do I need an MRI?', 'p' => 'Usually not at the start. MRI findings like "disc bulge" are extremely common in people with no pain at all, and scans too early often create anxiety without changing treatment. MRI is valuable when pain persists despite treatment, when nerve signs appear, or when surgery is being considered.'],
                ['h' => 'When to see a specialist', 'p' => 'See a specialist if pain lasts beyond 4–6 weeks despite sensible care, if it radiates below the knee with tingling or weakness, or if any warning sign is present. A structured evaluation will tell you clearly whether you need continued conservative care, targeted treatment or — in a minority — surgical opinion.'],
            ],
        ],

        'kidney-stones-guide' => [
            'title'    => 'Kidney Stones: Treatment, and More Importantly, Prevention',
            'category' => 'Kidney & Urology',
            'excerpt'  => 'Stone pain is unforgettable — but the real victory is making sure the next stone never forms.',
            'published'=> '2026-07-25',
            'updated'  => '2026-08-01',
            'readtime' => '5 min read',
            'author'   => 'Deccan Malti Hospital',
            'reviewer' => '',
            'body'     => [
                ['h' => 'What a stone feels like', 'p' => 'A stone moving down the ureter causes severe, wave-like pain in the flank or lower abdomen, often radiating to the groin, sometimes with nausea, vomiting or blood in the urine. The pain of a stuck stone is among the most intense people experience — but most small stones pass on their own with medicines and hydration.'],
                ['h' => 'When a stone is dangerous', 'p' => 'Stone pain with fever and chills means an infected, blocked kidney — a genuine emergency. Similarly, a stone in a single functioning kidney, or stones causing complete blockage, need urgent treatment. Severe uncontrolled pain or persistent vomiting also justify immediate care.'],
                ['h' => 'How stones are treated today', 'p' => 'Treatment depends on size and position. Small stones: medicines and waiting. Larger or stuck stones: endoscopic procedures — a fine telescope passed through natural passages to break the stone with laser — with no external cuts and short hospital stays. Open stone surgery is now rare.'],
                ['h' => 'Prevention is the real treatment', 'p' => 'About half of stone formers develop another stone within years unless prevention is taken seriously. The cornerstone is fluid — enough to keep urine pale through the day, roughly 2–2.5 litres of urine output. Dietary guidance follows your stone type: salt moderation helps nearly everyone; specific advice on calcium, oxalate and protein follows stone analysis. If you have passed or passed-out a stone, ask about metabolic evaluation — finding out why you form stones is the only way to stop the cycle.'],
                ['h' => 'One practical tip', 'p' => 'If you are a stone former, keep a bottle with you and finish it by midday, refill and finish by evening. The pale-urine rule is simple, free, and more powerful than any medicine.'],
            ],
        ],

        'joint-pain-when-to-worry' => [
            'title'    => 'Joint Pain After 50: Arthritis, Ageing, and When Replacement Makes Sense',
            'category' => 'Spine & Joints',
            'excerpt'  => 'Knee and hip pain is common after 50 — but suffering silently is not the only option. Know the graded approach.',
            'published'=> '2026-08-02',
            'updated'  => '2026-08-10',
            'readtime' => '6 min read',
            'author'   => 'Deccan Malti Hospital',
            'reviewer' => '',
            'body'     => [
                ['h' => 'What is osteoarthritis?', 'p' => 'Osteoarthritis is wear-and-tear of the smooth cartilage covering joint surfaces. Knees and hips, bearing our weight for decades, are affected most. Symptoms build gradually: pain on walking or stairs, morning stiffness easing within half an hour, and difficulty with squatting or sitting cross-legged.'],
                ['h' => 'The graded approach that actually works', 'p' => 'Treatment is a ladder, not a leap to surgery. Step one: weight management — every kilo lost reduces knee load several-fold while walking — plus quadriceps-strengthening exercises, which genuinely reduce pain. Step two: medicines for flares and physiotherapy for function. Step three, for selected patients: targeted injections. Surgery sits at the top of the ladder, for those whose pain and X-rays justify it.'],
                ['h' => 'When does replacement make sense?', 'p' => 'When pain meaningfully limits daily life — walking distance, sleep, stairs, independence — despite a proper trial of conservative treatment, and X-rays show advanced damage. Done at the right time, knee and hip replacement are among the most successful operations in medicine, with most patients walking with support within days and returning to routine life over about three months.'],
                ['h' => 'Questions to ask before deciding', 'p' => 'Ask how advanced your X-ray changes are, what non-surgical options remain genuinely untried, what the realistic recovery timeline looks like, and how long the implant is expected to last at your age and activity level. A good surgeon welcomes these questions.'],
                ['h' => 'The bottom line', 'p' => 'Neither suffer silently nor rush to surgery. Graded treatment serves most people well for years; timely replacement serves the rest reliably. The right answer depends on your symptoms, your X-rays and your life — not on a neighbour\'s experience.'],
            ],
        ],

        'diabetes-and-your-body' => [
            'title'    => 'Diabetes: Protecting Your Eyes, Kidneys, Nerves and Heart',
            'category' => 'General Health',
            'excerpt'  => 'Good diabetes care is measured by the organs it protects. The annual checklist every diabetic should follow.',
            'published'=> '2026-08-05',
            'updated'  => '2026-08-12',
            'readtime' => '6 min read',
            'author'   => 'Deccan Malti Hospital',
            'reviewer' => '',
            'body'     => [
                ['h' => 'Sugar control is a means, not the end', 'p' => 'The purpose of treating diabetes is not a good-looking report — it is protecting the organs that high sugar silently damages over years: eyes, kidneys, nerves, heart and feet. This reframing matters, because a person can feel perfectly well while damage accumulates. Feeling fine is not the same as being protected.'],
                ['h' => 'The annual protection checklist', 'p' => 'Every person with diabetes needs, at minimum, once a year: an eye examination for retinopathy; urine albumin and creatinine for kidneys; a foot examination for nerve and circulation problems; HbA1c and lipid profile; and blood pressure checks at every visit. These are not optional extras — they are how complications are caught while still reversible or slowable.'],
                ['h' => 'Feet: the most neglected inch of diabetes', 'p' => 'Nerve damage removes the pain that normally warns of injury, so small wounds become deep ulcers unnoticed. Inspect your feet daily, never walk barefoot, trim nails carefully, moisturise dry skin, and treat any wound — however small — with respect. A painless wound in a diabetic is never trivial.'],
                ['h' => 'Blood pressure, cholesterol and tobacco', 'p' => 'For heart protection in diabetes, blood pressure and cholesterol control matter nearly as much as sugar. And tobacco in any form multiplies the damage to every organ diabetes threatens — quitting is the single highest-value change a diabetic smoker can make.'],
                ['h' => 'The realistic goal', 'p' => 'Perfection is not required; consistency is. Regular medicines, the annual checklist, daily activity and honest review visits — this unglamorous routine is what prevents the amputations, dialysis and vision loss that uncontrolled diabetes causes.'],
            ],
        ],

        'cancer-warning-signs' => [
            'title'    => 'Cancer Warning Signs: What to Watch, and Why Early Evaluation Wins',
            'category' => 'Cancer Care',
            'excerpt'  => 'Most warning signs turn out to be something simple — but the ones that are cancer are best found early.',
            'published'=> '2026-08-08',
            'updated'  => '2026-08-15',
            'readtime' => '5 min read',
            'author'   => 'Deccan Malti Hospital',
            'reviewer' => '',
            'body'     => [
                ['h' => 'Why early changes everything', 'p' => 'Cancer treatment outcomes depend more on stage at diagnosis than almost anything else. Early-stage breast, oral and colorectal cancers are frequently curable; the same cancers found late are far harder to treat. Early evaluation of warning signs is not anxiety — it is strategy.'],
                ['h' => 'Signs that deserve prompt evaluation', 'p' => 'Any new lump anywhere. A mouth ulcer or white/red patch not healing in three weeks — especially in tobacco users. Unusual bleeding: in stool or urine, between periods or after menopause, or in sputum. Unexplained weight loss, persistent fever or night sweats. A change in bowel or bladder habits that persists. Progressive difficulty swallowing. A cough or hoarseness beyond three weeks. A mole that changes in size, shape or colour.'],
                ['h' => 'What evaluation involves', 'p' => 'Usually an examination, an imaging test and — where needed — a biopsy. Most people evaluated for warning signs do not have cancer, and leave reassured with the cause treated. Those who do have cancer are precisely the ones who benefit from having come early. Either way, evaluation wins.'],
                ['h' => 'Tobacco: the exception to every rule', 'p' => 'Tobacco in any form — smoked or chewed — is the single largest preventable cause of cancer in our region. Quitting at any age reduces risk. If you use tobacco and have any persistent mouth, throat or voice change, do not wait.'],
                ['h' => 'A note on fear', 'p' => 'Many people delay evaluation because they fear the answer. But the information exists whether or not you collect it — and every week of delay narrows options while delay itself provides no protection. Courage, in this case, is simply an appointment.'],
            ],
        ],

        'hernia-questions-answered' => [
            'title'    => 'Hernia: The Questions Patients Ask, Answered Honestly',
            'category' => 'Surgery',
            'excerpt'  => 'Does a hernia heal on its own? Is surgery always needed? What happens if you wait? Straight answers.',
            'published'=> '2026-08-10',
            'updated'  => '2026-08-15',
            'readtime' => '4 min read',
            'author'   => 'Deccan Malti Hospital',
            'reviewer' => '',
            'body'     => [
                ['h' => 'What exactly is a hernia?', 'p' => 'A hernia is a weakness or opening in the abdominal wall through which inner contents push out, appearing as a swelling — commonly in the groin or near the navel — that typically enlarges on standing, coughing or straining and reduces on lying down. It is a mechanical defect, not a tumour or infection.'],
                ['h' => 'Can it heal without surgery?', 'p' => 'No. Because the problem is a physical opening, no medicine, exercise or belt can close it. Belts may hold the swelling in temporarily but do not treat the defect. Surgical repair — usually with a mesh that reinforces the weakness — is the only definitive treatment.'],
                ['h' => 'What happens if I just leave it?', 'p' => 'Many hernias enlarge slowly and cause only discomfort — which tempts delay. The risk in waiting is obstruction: a loop of intestine getting stuck in the hernia, becoming painful, hard and irreducible. That is an emergency operation with higher risk than the planned repair that was postponed. Planned surgery is safer, simpler and often day-care.'],
                ['h' => 'What is recovery like?', 'p' => 'Most laparoscopic hernia repairs mean walking the same day, home the same or next day, desk work in one to two weeks, and heavy lifting deferred for six to twelve weeks. Following the lifting advice is your part in preventing recurrence.'],
                ['h' => 'When to act', 'p' => 'If you have a hernia, plan the repair at a convenient time rather than waiting for it to choose an inconvenient one. And if your hernia ever becomes painful, hard and irreducible — especially with vomiting — treat it as an emergency.'],
            ],
        ],
    ];
}
