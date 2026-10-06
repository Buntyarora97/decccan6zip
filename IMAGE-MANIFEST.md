# IMAGE MANIFEST — Deccan Malti Hospital Website

Har image ka filename, placement, ratio, alt text aur replacement status.

The website now serves WebP assets. The original camera files are retained in `assets/img/all images/` as source-quality backups; runtime pages use the converted files in `assets/img/real/`.

---

## Brand assets

| File | Size / Ratio | Placement | Alt text | Status |
|---|---|---|---|---|
| `assets/img/logo.webp` | square | Header, footer, admin login | "Deccan Malti Hospital logo" (empty alt where adjacent brand text exists) | Converted WebP |
| `assets/img/favicon.webp` | 64×64 | Browser tab favicon | — | Converted WebP |
| `assets/img/og-default.webp` | 1200×630 | Social share / Open Graph default | — | Converted WebP |

## Homepage — `assets/img/real/`

| File | Ratio | Section | Alt text | Status |
|---|---|---|---|---|
| `p6a6119.webp` | 3:2 | S1 hero poster, facilities, about and gallery | "Deccan Malti Hospital entrance, Sangli" | Real hospital photograph |
| `p6a5854.webp` | 2:3 | S1 orbit slider, about, departments | "Deccan Malti Hospital welcome display and corridor" | Real hospital photograph |
| `p6a5935.webp` | 2:3 | S1 orbit slider, reception and gallery | "Reception and corridor at Deccan Malti Hospital" | Real hospital photograph |
| `p6a6088.webp` | 3:2 | S1 orbit slider, care room and gallery | "Patient care room at Deccan Malti Hospital" | Real hospital photograph |
| `p6a5856.webp` | 2:3 | S3 about split | "Deccan Malti Hospital welcome display and corridor" | Real hospital photograph |
| `p6a6030.webp` | 3:2 | S5 neuro/OT feature, gallery | "Operating theatre at Deccan Malti Hospital" | Real hospital photograph |
| `p6a5831.webp` | 3:2 | Facilities, rooms and gallery | "Patient room at Deccan Malti Hospital" | Real hospital photograph |
| `p6a5802.webp` | 3:2 | Corridors and gallery | "Hospital corridor at Deccan Malti Hospital" | Real hospital photograph |
| `p6a5774.webp` | 3:2 | Ward, departments, articles and gallery | "In-patient ward at Deccan Malti Hospital" | Real hospital photograph |

## Doctors — `assets/img/real/`

| File | Ratio | Placement | Alt text | Status |
|---|---|---|---|---|
| `dr-p-c-patil.webp` | 1:1.13 | Dr. P. C. Patil profile, directory and homepage doctors slider | "Dr. P. C. Patil, Co-Founder and General Surgeon at Deccan Malti Hospital, Sangli" | Portrait supplied by the hospital; confirm identity before production |
| `dr-rohan-patil.webp` | 0.78:1 | Dr. Rohan Patil profile, directory and homepage doctors slider | "Dr. Rohan Patil, Co-Founder and Neurosurgeon at Deccan Malti Hospital, Sangli" | Portrait supplied by the hospital |

## Newly supplied hospital photos — `assets/img/real/`

| File | Placement | Alt text | Status |
|---|---|---|---|
| `hospital-reception-lobby.webp` | Homepage hero | "Reception lobby at Deccan Malti Neuro & Superspeciality Hospital, Sangli" | Supplied photo; optimized WebP |
| `hospital-reception-guidance-desk.webp` | Homepage, About, Facilities and Gallery | "Reception and patient guidance desk at Deccan Malti Hospital, Sangli" | Supplied photo; optimized WebP |
| `hospital-reception-team.webp` | Homepage, About and Gallery | "Hospital reception team at Deccan Malti Hospital, Sangli" | Supplied photo; optimized WebP |
| `hospital-patient-room.webp` | Homepage, About, Facilities and Gallery | "Patient-care room with beds and medical equipment at Deccan Malti Hospital, Sangli" | Supplied empty-room photo; optimized WebP |

The supplied bedside-care photo showing patients was not published because patient consent is not documented. The two pharmacy-front photos were not published because their signage names Malati Nursing Home Pharmacy; the relationship to Deccan Malti Hospital needs confirmation first.

## Departments — `assets/img/real/`

| File | Ratio | Placement | Alt text | Status |
|---|---|---|---|---|
| `p6a6030.webp` | 3:2 | Neurosurgery, general surgery | "Operating theatre at Deccan Malti Hospital" | Real hospital photograph |
| `p6a5774.webp` | 3:2 | Neurology, oncology, nephrology | "In-patient ward at Deccan Malti Hospital" | Real hospital photograph |
| `p6a6088.webp` | 3:2 | Cardiology, urology | "Patient care room at Deccan Malti Hospital" | Real hospital photograph |
| `p6a5831.webp` | 3:2 | Orthopaedics, colorectal surgery | "Patient room at Deccan Malti Hospital" | Real hospital photograph |
| `p6a5854.webp` | 2:3 | Plastic surgery | "Deccan Malti Hospital welcome display and corridor" | Real hospital photograph |

## Health library articles — `assets/img/real/`

| File | Ratio | Placement | Alt text | Status |
|---|---|---|---|---|
| `p6a5774.webp` | 3:2 | Stroke, diabetes article cards and heroes | "In-patient ward at Deccan Malti Hospital" | Real hospital photograph |
| `p6a5802.webp` | 3:2 | Back pain article card and hero | "Hospital corridor at Deccan Malti Hospital" | Real hospital photograph |
| `p6a6088.webp` | 3:2 | Stones, cancer article cards and heroes | "Patient care room at Deccan Malti Hospital" | Real hospital photograph |
| `p6a5831.webp` | 3:2 | Joint and hernia article cards and heroes | "Patient room at Deccan Malti Hospital" | Real hospital photograph |

## Gallery page

Gallery now uses the real hospital photography in `assets/img/real/`, curated by subject in `pages/gallery.php`.

## Asset maintenance

1. Add approved real photography to `assets/img/real/` as WebP; keep the camera originals only in `assets/img/all images/`.
2. Maintain the source composition: `3:2` for cards, `2:3` for portrait slots, and crop with CSS where needed.
3. The runtime serves WebP derivatives. Selected large page images are capped at 1280 px and recompressed at quality 82; the supplied and camera originals remain in the source-assets folders.
4. Keep the homepage hero image eager-loaded and high priority; load below-the-fold images lazily.
