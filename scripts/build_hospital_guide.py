#!/usr/bin/env python3
"""Build the downloadable hospital guide PDF from the approved public summary."""

from pathlib import Path
import subprocess
import tempfile

import pymupdf as fitz


ROOT = Path(__file__).resolve().parents[1]
OUTPUT = ROOT / "assets" / "docs" / "deccan-malti-hospital-guide.pdf"
LOGO = ROOT / "assets" / "img" / "logo-mark.webp"
COVER = ROOT / "assets" / "img" / "hospital-shoot" / "hospital-exterior-front.webp"

PAGE_W, PAGE_H = 595.28, 841.89
NAVY = (12 / 255, 50 / 255, 133 / 255)
BLUE = (0 / 255, 106 / 255, 193 / 255)
GREEN = (25 / 255, 156 / 255, 60 / 255)
INK = (32 / 255, 37 / 255, 45 / 255)
MUTED = (82 / 255, 97 / 255, 116 / 255)
LINE = (220 / 255, 231 / 255, 244 / 255)
PAPER = (247 / 255, 249 / 255, 252 / 255)
WHITE = (1, 1, 1)

SPECIALTIES = [
    ("Neurosurgery", "Specialist assessment of conditions affecting the brain, spine and nervous system."),
    ("Plastic & Reconstructive Surgery", "Consultation for reconstructive and restorative care related to injury, illness or other conditions."),
    ("Colorectal Surgery", "Evaluation of conditions involving the colon, rectum and related structures."),
    ("Anorectal Surgery", "Specialist assessment of conditions affecting the anal and rectal area."),
    ("Joint Replacement", "Evaluation of joint pain and mobility concerns, including discussion of treatment options."),
    ("Neurology", "Assessment of conditions affecting the brain, spinal cord, nerves and muscles."),
    ("Urology", "Consultation for conditions involving the urinary system and related concerns."),
    ("Oncology", "Medical consultation and guidance for people facing a cancer diagnosis or concern."),
    ("Nephrology", "Assessment and medical care for kidney-related conditions."),
]
OTHER_SPECIALTIES = [
    ("General Medicine", "First medical assessment for common health concerns and ongoing conditions."),
    ("General Surgery", "Surgical consultation to assess a concern and explain appropriate care options."),
    ("Laparoscopic Surgery", "Consultation about minimally invasive surgical approaches where clinically appropriate."),
    ("Orthopaedics", "Assessment of bone, joint and movement-related concerns."),
    ("Cardiology", "Evaluation of symptoms and conditions involving the heart and circulation."),
]
DIAGNOSTICS = [
    ("Radiology", "Medical imaging can help clinicians assess and monitor a range of conditions."),
    ("CT Scan", "Computed tomography creates cross-sectional images to support clinical evaluation."),
    ("Digital X-Ray", "X-ray imaging supports assessment of selected bones and body areas."),
    ("EEG", "An electroencephalogram records electrical activity in the brain for clinical assessment."),
    ("NCV", "A nerve conduction study measures how signals travel through selected peripheral nerves."),
    ("Pathology & Laboratory Services", "Laboratory investigations provide information clinicians consider alongside symptoms and examination."),
]
ALLIED = [
    ("Pharmacy", "The hospital lists a 24/7 pharmacy service."),
    ("Physiotherapy & Rehabilitation Centre", "Physiotherapy and rehabilitation support movement, function and recovery goals."),
    ("Ambulance Service", "Contact the hospital to confirm current ambulance arrangements and availability."),
]
CRITICAL_CARE = [
    ("Casualty / Emergency Care", "Emergency care category for urgent medical concerns."),
    ("Intensive Care Unit (ICU)", "Intensive-care category for patients requiring closer medical monitoring, as determined by the treating team."),
    ("High Dependency Unit (HDU)", "Higher-dependency care category; suitability is determined by the clinical team."),
]
ROOMS = [
    ("General Ward - Male", "General inpatient accommodation for male patients. Confirm current availability with the hospital."),
    ("General Ward - Female", "General inpatient accommodation for female patients. Confirm current availability with the hospital."),
    ("AC Single / Deluxe Room", "Air-conditioned single-room category. Confirm the room category and availability with the hospital."),
    ("Non-AC Single / Deluxe Room", "Non-air-conditioned single-room category. Confirm the room category and availability with the hospital."),
    ("Suite Room", "Suite room category. Ask the hospital team about details and current availability."),
]
INFRASTRUCTURE = [
    ("Modular Operation Theatre", "Modular OT with air-filtration infrastructure."),
    ("Pentero Surgical Microscope", "Supports magnified visualisation during selected procedures."),
    ("CUSA Technology", "Cavitron Ultrasonic Surgical Aspirator technology; suitability is decided by the treating specialist."),
    ("In-house CT Scan", "CT scan available within the hospital; imaging is advised based on clinical assessment."),
    ("Pathology & Laboratory Services", "Laboratory investigations that clinicians may use to support assessment and care."),
    ("24/7 Pharmacy", "Hospital pharmacy service listed as available around the clock."),
    ("Physiotherapy & Rehabilitation", "Department for physiotherapy and rehabilitation support."),
    ("Cashless Insurance Assistance", "Ask about policy-specific network status; eligibility and approvals depend on the insurer."),
    ("CMRF Guidance", "Chief Minister's Relief Fund guidance; eligibility and assistance depend on programme rules and approval."),
]


def safe_text(text: str) -> str:
    return (
        text.replace("’", "'").replace("‘", "'")
        .replace("–", "-").replace("—", "-").replace("×", "x")
        .replace("“", '"').replace("”", '"')
    )


def textbox(page, rect, text, size=10, color=INK, font="helv", align=0, lineheight=1.23):
    return page.insert_textbox(
        rect,
        safe_text(text),
        fontsize=size,
        fontname=font,
        color=color,
        align=align,
        lineheight=lineheight,
    )


def draw_header(page, title, subtitle, logo_path):
    page.draw_rect(fitz.Rect(0, 0, PAGE_W, 106), color=NAVY, fill=NAVY)
    page.insert_text((38, 46), safe_text(title), fontsize=21, fontname="hebo", color=WHITE)
    textbox(page, fitz.Rect(39, 62, PAGE_W - 78, 92), subtitle, 9.5, (0.88, 0.93, 1), "helv")
    page.draw_circle((PAGE_W - 54, 53), 24, color=None, fill=WHITE)
    page.insert_image(fitz.Rect(PAGE_W - 72, 35, PAGE_W - 36, 71), filename=str(logo_path), keep_proportion=True)


def draw_footer(page, number):
    page.draw_line((38, 808), (PAGE_W - 38, 808), color=LINE, width=0.8)
    textbox(page, fitz.Rect(38, 815, PAGE_W - 110, 832), "Deccan Malti Hospital | Vishrambag, Sangli", 8, MUTED)
    textbox(page, fitz.Rect(PAGE_W - 95, 815, PAGE_W - 38, 832), f"{number} / 5", 8, MUTED, align=2)


def draw_section_title(page, y, title, note=None):
    textbox(page, fitz.Rect(38, y, PAGE_W - 38, y + 22), title, 13, NAVY, "hebo", lineheight=1.1)
    page.draw_line((38, y + 27), (PAGE_W - 38, y + 27), color=GREEN, width=1.3)
    if note:
        textbox(page, fitz.Rect(38, y + 33, PAGE_W - 38, y + 52), note, 8.2, MUTED)


def draw_card(page, rect, title, description, compact=False):
    page.draw_rect(rect, color=LINE, fill=WHITE, width=0.7)
    page.draw_rect(fitz.Rect(rect.x0, rect.y0, rect.x0 + 3, rect.y1), color=GREEN, fill=GREEN)
    title_size = 8.5 if compact else 9
    title_rect = fitz.Rect(rect.x0 + 11, rect.y0 + 8, rect.x1 - 8, rect.y0 + 30)
    remaining = textbox(page, title_rect, title, title_size, NAVY, "hebo", lineheight=1.08)
    if remaining < 0:
        raise ValueError(f"Guide title does not fit: {title}")
    body_rect = fitz.Rect(rect.x0 + 11, rect.y0 + 33, rect.x1 - 8, rect.y1 - 7)
    remaining = textbox(page, body_rect, description, 7.8 if compact else 8.2, MUTED, lineheight=1.18)
    if remaining < 0:
        raise ValueError(f"Guide description does not fit: {title}")


def card_grid(page, items, x, y, columns, card_height, gap_x=12, gap_y=10, compact=False):
    margin = 38
    usable = PAGE_W - 2 * margin
    width = (usable - gap_x * (columns - 1)) / columns
    for i, (title, description) in enumerate(items):
        row, column = divmod(i, columns)
        left = x + column * (width + gap_x)
        top = y + row * (card_height + gap_y)
        draw_card(page, fitz.Rect(left, top, left + width, top + card_height), title, description, compact)
    return y + ((len(items) + columns - 1) // columns) * (card_height + gap_y)


def build_pdf():
    if not COVER.exists() or not LOGO.exists():
        raise FileNotFoundError("The verified cover photograph or hospital logo is missing.")
    OUTPUT.parent.mkdir(parents=True, exist_ok=True)
    document = fitz.open()
    document.set_metadata({
        "title": "Deccan Malti Hospital Guide",
        "author": "Deccan Malti Hospital",
        "subject": "Hospital services, facilities and visit information",
        "keywords": "Deccan Malti Hospital, Sangli, services, facilities",
    })

    with tempfile.TemporaryDirectory(prefix="deccan-malti-guide-") as temporary:
        temp = Path(temporary)
        logo_png = temp / "logo.png"
        cover_jpg = temp / "cover.jpg"
        subprocess.run(["magick", str(LOGO), "-strip", str(logo_png)], check=True)
        subprocess.run(["magick", str(COVER), "-strip", "-quality", "88", str(cover_jpg)], check=True)

        # Page 1: identity, complete-frame exterior photograph and verified contact details.
        page = document.new_page(width=PAGE_W, height=PAGE_H)
        page.draw_rect(fitz.Rect(0, 0, PAGE_W, PAGE_H), color=WHITE, fill=WHITE)
        page.draw_rect(fitz.Rect(0, 0, PAGE_W, 194), color=NAVY, fill=NAVY)
        page.draw_circle((77, 69), 35, color=None, fill=WHITE)
        page.insert_image(fitz.Rect(51, 43, 103, 95), filename=str(logo_png), keep_proportion=True)
        page.insert_text((126, 62), "DECCAN MALTI HOSPITAL", fontsize=18, fontname="hebo", color=WHITE)
        page.insert_text((127, 90), "Neuro, ICU & Superspeciality Hospital", fontsize=10.5, fontname="helv", color=(0.9, 0.94, 1))
        page.insert_text((127, 115), "Life Prevails", fontsize=9, fontname="helv", color=(0.83, 0.91, 1))
        page.draw_line((40, 152), (PAGE_W - 40, 152), color=(0.3, 0.57, 0.88), width=0.8)
        textbox(page, fitz.Rect(40, 164, PAGE_W - 40, 185), "HOSPITAL GUIDE  |  SERVICES, FACILITIES & VISIT INFORMATION", 8.2, WHITE, "hebo")

        page.draw_rect(fitz.Rect(38, 218, PAGE_W - 38, 563), color=LINE, fill=PAPER, width=0.8)
        page.insert_image(fitz.Rect(44, 224, PAGE_W - 44, 557), filename=str(cover_jpg), keep_proportion=True)
        textbox(page, fitz.Rect(42, 574, PAGE_W - 42, 598), "A guide to the hospital's listed services and patient support.", 10, NAVY, "hebo")

        page.draw_rect(fitz.Rect(38, 610, PAGE_W - 38, 781), color=LINE, fill=WHITE, width=0.8)
        page.draw_rect(fitz.Rect(38, 610, PAGE_W - 38, 646), color=GREEN, fill=GREEN)
        textbox(page, fitz.Rect(51, 619, PAGE_W - 48, 641), "VISIT DECCAN MALTI HOSPITAL", 11, WHITE, "hebo")
        textbox(
            page,
            fitz.Rect(51, 658, PAGE_W - 51, 705),
            "Opp. Ambassador Hotel, besides Sushil Hospital, Sangli-Miraj Road, Vishrambag, Sangli, Maharashtra - 416415",
            9.2,
            INK,
            lineheight=1.25,
        )
        textbox(page, fitz.Rect(51, 716, 300, 748), "Appointments & enquiries\n" + "+91 883 000 6879", 9, NAVY, "hebo")
        textbox(page, fitz.Rect(315, 716, PAGE_W - 50, 748), "Landline\n0233-2324834", 9, NAVY, "hebo")
        textbox(page, fitz.Rect(51, 758, PAGE_W - 51, 775), "Call ahead to confirm current service, appointment and room availability.", 7.8, MUTED)
        draw_footer(page, 1)

        # Page 2: all listed clinical specialities.
        page = document.new_page(width=PAGE_W, height=PAGE_H)
        draw_header(page, "Clinical Services", "Speciality names and descriptions are a general guide; care is based on clinical assessment.", logo_png)
        draw_section_title(page, 130, "Super Specialities")
        card_grid(page, SPECIALTIES, 38, 164, 3, 104, gap_x=12, gap_y=10)
        draw_section_title(page, 516, "Other Specialities")
        card_grid(page, OTHER_SPECIALTIES, 38, 550, 3, 91, gap_x=12, gap_y=10, compact=True)
        draw_footer(page, 2)

        # Page 3: diagnostic and allied services.
        page = document.new_page(width=PAGE_W, height=PAGE_H)
        draw_header(page, "Diagnostics & Allied Support", "Investigations and support services listed by Deccan Malti Hospital.", logo_png)
        draw_section_title(page, 130, "Diagnostic Services")
        card_grid(page, DIAGNOSTICS, 38, 164, 2, 86, gap_x=14, gap_y=10, compact=True)
        draw_section_title(page, 470, "Allied & Supportive Services")
        card_grid(page, ALLIED, 38, 504, 3, 92, gap_x=12, gap_y=10, compact=True)
        page.draw_rect(fitz.Rect(38, 622, PAGE_W - 38, 760), color=LINE, fill=PAPER, width=0.7)
        textbox(page, fitz.Rect(54, 639, PAGE_W - 54, 664), "Please confirm availability and requirements directly.", 10, NAVY, "hebo")
        textbox(page, fitz.Rect(54, 675, PAGE_W - 54, 748), "The hospital team can advise about current service availability. An ambulance enquiry should be confirmed directly with the hospital. For a life-threatening emergency, call local emergency services or go to the nearest emergency facility.", 9, MUTED, lineheight=1.3)
        draw_footer(page, 3)

        # Page 4: care categories and accommodation. No counts or availability are inferred.
        page = document.new_page(width=PAGE_W, height=PAGE_H)
        draw_header(page, "Critical Care & Rooms", "Ask the hospital team about room categories, suitability and current availability.", logo_png)
        draw_section_title(page, 130, "Emergency & Critical Care")
        card_grid(page, CRITICAL_CARE, 38, 164, 3, 98, gap_x=12, gap_y=10, compact=True)
        draw_section_title(page, 300, "Room Categories")
        card_grid(page, ROOMS, 38, 334, 2, 87, gap_x=14, gap_y=10, compact=True)
        page.draw_rect(fitz.Rect(38, 638, PAGE_W - 38, 758), color=LINE, fill=PAPER, width=0.7)
        textbox(page, fitz.Rect(54, 654, PAGE_W - 54, 679), "Room enquiries", 10, NAVY, "hebo")
        textbox(page, fitz.Rect(54, 689, PAGE_W - 54, 742), "Room type, suitability and availability are confirmed by the hospital. An online or telephone enquiry does not reserve a room. No room or ICU/HDU capacity figures are published in this guide.", 9, MUTED, lineheight=1.3)
        draw_footer(page, 4)

        # Page 5: infrastructure, insurance guidance and how to plan a visit.
        page = document.new_page(width=PAGE_W, height=PAGE_H)
        draw_header(page, "Infrastructure & Planning a Visit", "Confirm current service details and eligibility with the hospital and relevant authority.", logo_png)
        draw_section_title(page, 130, "Facilities & Patient Support")
        card_grid(page, INFRASTRUCTURE, 38, 164, 3, 100, gap_x=12, gap_y=10, compact=True)
        page.draw_rect(fitz.Rect(38, 504, PAGE_W - 38, 760), color=LINE, fill=PAPER, width=0.7)
        textbox(page, fitz.Rect(54, 520, PAGE_W - 54, 543), "Before your visit", 11, NAVY, "hebo")
        textbox(
            page,
            fitz.Rect(54, 550, PAGE_W - 54, 626),
            "Bring relevant previous reports, prescriptions and a list of current medicines if applicable. Ask the hospital to confirm appointment timing, service availability and room categories.",
            9,
            MUTED,
            lineheight=1.3,
        )
        textbox(page, fitz.Rect(54, 633, PAGE_W - 54, 649), "Insurance & CMRF", 10, NAVY, "hebo")
        textbox(
            page,
            fitz.Rect(54, 655, PAGE_W - 54, 736),
            "Cashless insurance eligibility, policy coverage and approval depend on the insurer. Chief Minister's Relief Fund (CMRF) eligibility and assistance depend on programme rules and approval by the relevant authority. Contact the hospital and the relevant organisation for current guidance.",
            8.6,
            MUTED,
            lineheight=1.25,
        )
        draw_footer(page, 5)

    document.save(OUTPUT, garbage=4, deflate=True, clean=True)
    document.close()
    print(f"Created {OUTPUT.relative_to(ROOT)}")


if __name__ == "__main__":
    build_pdf()
