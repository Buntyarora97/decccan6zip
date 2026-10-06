import './_group.css';
import {
  Activity,
  Ambulance,
  ArrowRight,
  AudioLines,
  Bone,
  Brain,
  CalendarDays,
  Download,
  FlaskConical,
  Hand,
  Heart,
  Pill,
  Ribbon,
  ScanLine,
  Stethoscope,
  type LucideIcon,
} from 'lucide-react';

type Service = {
  id: string;
  name: string;
  icon: string;
  summary: string;
  department?: string;
};

type ServiceGroup = {
  name: string;
  services: Service[];
};

type ServiceCategory = {
  id: string;
  label: string;
  groups: ServiceGroup[];
};

const iconSet: Record<string, LucideIcon> = {
  brain: Brain,
  hand: Hand,
  activity: Activity,
  bone: Bone,
  heart: Heart,
  stetho: Stethoscope,
  ribbon: Ribbon,
  scan: ScanLine,
  pulse: AudioLines,
  flask: FlaskConical,
  pill: Pill,
  ambulance: Ambulance,
};

const categories: ServiceCategory[] = [
  {
    id: 'clinical',
    label: 'Clinical Services',
    groups: [
      {
        name: 'Super Specialities',
        services: [
          { id: 'neurosurgery', name: 'Neurosurgery', icon: 'brain', department: 'neurosurgery', summary: 'Specialist assessment of conditions affecting the brain, spine and nervous system.' },
          { id: 'plastic-reconstructive-surgery', name: 'Plastic & Reconstructive Surgery', icon: 'hand', department: 'plastic-reconstructive-surgery', summary: 'Consultation for reconstructive and restorative care related to injury, illness or other conditions.' },
          { id: 'colorectal-surgery', name: 'Colorectal Surgery', icon: 'activity', department: 'colorectal-surgery', summary: 'Evaluation of conditions involving the colon, rectum and related structures.' },
          { id: 'anorectal-surgery', name: 'Anorectal Surgery', icon: 'activity', summary: 'Specialist assessment of conditions affecting the anal and rectal area.' },
          { id: 'joint-replacement', name: 'Joint Replacement', icon: 'bone', department: 'orthopaedics-joint-replacement', summary: 'Evaluation of joint pain and mobility concerns, including discussion of treatment options.' },
          { id: 'neurology', name: 'Neurology', icon: 'brain', department: 'neurology', summary: 'Assessment of conditions affecting the brain, spinal cord, nerves and muscles.' },
          { id: 'urology', name: 'Urology', icon: 'activity', department: 'urology', summary: 'Consultation for conditions involving the urinary system and related concerns.' },
          { id: 'oncology', name: 'Oncology', icon: 'ribbon', department: 'oncology', summary: 'Medical consultation and guidance for people facing a cancer diagnosis or concern.' },
          { id: 'nephrology', name: 'Nephrology', icon: 'activity', department: 'nephrology', summary: 'Assessment and medical care for kidney-related conditions.' },
        ],
      },
      {
        name: 'Other Specialities',
        services: [
          { id: 'cardiology', name: 'Cardiology', icon: 'heart', department: 'cardiology', summary: 'Evaluation of symptoms and conditions involving the heart and circulation.' },
          { id: 'general-medicine', name: 'General Medicine', icon: 'stetho', summary: 'First medical assessment for common health concerns and ongoing conditions.' },
          { id: 'general-surgery', name: 'General Surgery', icon: 'activity', department: 'general-surgery', summary: 'Surgical consultation to assess a concern and explain appropriate care options.' },
          { id: 'laparoscopic-surgery', name: 'Laparoscopic Surgery', icon: 'activity', summary: 'Consultation about minimally invasive surgical approaches where clinically appropriate.' },
          { id: 'orthopaedics', name: 'Orthopaedics', icon: 'bone', summary: 'Assessment of bone, joint and movement-related concerns.' },
        ],
      },
    ],
  },
  {
    id: 'diagnostic',
    label: 'Diagnostic Services',
    groups: [
      {
        name: 'Diagnostic Services',
        services: [
          { id: 'radiology', name: 'Radiology', icon: 'scan', summary: 'Medical imaging can help clinicians assess and monitor a range of conditions.' },
          { id: 'ct-scan', name: 'CT Scan', icon: 'scan', summary: 'Computed tomography creates cross-sectional images to support clinical evaluation.' },
          { id: 'digital-x-ray', name: 'Digital X-Ray', icon: 'scan', summary: 'X-ray imaging supports assessment of selected bones and body areas.' },
          { id: 'eeg', name: 'EEG', icon: 'pulse', summary: 'An electroencephalogram records electrical activity in the brain for clinical assessment.' },
          { id: 'ncv', name: 'NCV', icon: 'pulse', summary: 'A nerve conduction study measures how signals travel through selected peripheral nerves.' },
          { id: 'pathology-laboratory', name: 'Pathology & Laboratory Services', icon: 'flask', summary: 'Laboratory investigations provide information that clinicians consider alongside symptoms and examination.' },
        ],
      },
    ],
  },
  {
    id: 'allied',
    label: 'Allied & Supportive Services',
    groups: [
      {
        name: 'Allied & Supportive Services',
        services: [
          { id: 'pharmacy', name: 'Pharmacy', icon: 'pill', summary: 'The hospital pharmacy supports patients with prescribed medicines; pharmacy service is listed as 24/7.' },
          { id: 'physiotherapy-rehabilitation', name: 'Physiotherapy & Rehabilitation Centre', icon: 'activity', summary: 'Physiotherapy and rehabilitation support movement, function and recovery goals.' },
          { id: 'ambulance-service', name: 'Ambulance Service', icon: 'ambulance', summary: 'For ambulance enquiries, contact the hospital to confirm current arrangements and availability.' },
        ],
      },
    ],
  },
];

function serviceUrl(service: Service) {
  return service.department
    ? `/departments/${service.department}`
    : `/departments#service-${service.id}`;
}

function ServiceCard({ service }: { service: Service }) {
  const Icon = iconSet[service.icon];
  return (
    <article className="current-card" id={`service-${service.id}`}>
      <span className="current-card__icon" aria-hidden="true"><Icon /></span>
      <h3>{service.name}</h3>
      <p>{service.summary}</p>
      <div className="current-card__actions">
        {service.department && (
          <a href={serviceUrl(service)}>
            Department overview <ArrowRight aria-hidden="true" />
          </a>
        )}
        <a href="/appointment">
          Request a consultation <CalendarDays aria-hidden="true" />
        </a>
      </div>
    </article>
  );
}

export function Current() {
  return (
    <main className="services-page current-page">
      <header className="current-hero">
        <div className="dm-container current-hero__content">
          <nav className="dm-breadcrumbs" aria-label="Breadcrumb">
            <a href="/">Home</a><span aria-hidden="true">/</span><span aria-current="page">Services</span>
          </nav>
          <h1>Services &amp; Specialities</h1>
          <p className="current-hero__lead">
            Browse clinical care, diagnostic services and allied support at Deccan Malti Hospital. Each service links to an overview or a consultation request.
          </p>
        </div>
      </header>

      <div className="services-page__body current-directory">
        <div className="dm-container">
          {categories.map((category) => (
            <section className="current-category" id={category.id} key={category.id}>
              <div className="current-category__head">
                <span className="current-eyebrow">{category.label}</span>
                <h2>{category.label}</h2>
              </div>
              <div className="current-catalog">
                {category.groups.map((group) => (
                  <section className="current-group" key={group.name}>
                    {category.id === 'clinical' && <h3>{group.name}</h3>}
                    <div className="current-group__cards">
                      {group.services.map((service) => <ServiceCard key={service.id} service={service} />)}
                    </div>
                  </section>
                ))}
              </div>
            </section>
          ))}

          <aside className="current-support">
            <p>For urgent symptoms, seek immediate emergency care. For questions about a service, contact the hospital team.</p>
            <a href="/contact" className="dm-button dm-button--outline">Contact the hospital <ArrowRight aria-hidden="true" /></a>
            <a href="/assets/docs/deccan-malti-hospital-guide.pdf" download="Deccan-Malti-Hospital-Guide.pdf" className="dm-button dm-button--primary">
              <Download aria-hidden="true" /> Download Hospital Guide (PDF)
            </a>
          </aside>

          <section className="current-cta" aria-labelledby="current-cta-title">
            <div>
              <h2 id="current-cta-title">Ready to talk to a specialist?</h2>
              <p>Request an appointment and our team will call you to confirm a convenient slot.</p>
            </div>
            <a href="/appointment" className="dm-button"><CalendarDays aria-hidden="true" /> Request an appointment</a>
          </section>
        </div>
      </div>
    </main>
  );
}
