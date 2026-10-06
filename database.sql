-- =============================================================
-- Deccan Malti Neuro & Superspeciality Hospital — MySQL Schema
-- MySQL 8 / MariaDB 10.4+
--
-- Shared hosting: phpMyAdmin mein pehle apna created database select
-- karke is file ko Import karein. CREATE DATABASE / USE intentionally
-- nahi diya gaya hai, taaki cPanel/Hostinger par permissions ki zarurat
-- na pade aur schema selected database mein hi create ho.
-- =============================================================

-- ---------- Admin users ----------
CREATE TABLE IF NOT EXISTS admin_users (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name          VARCHAR(120) NOT NULL,
  email         VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role          ENUM('admin','staff') NOT NULL DEFAULT 'admin',
  is_active     TINYINT(1) NOT NULL DEFAULT 1,
  last_login_at DATETIME NULL,
  created_at    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------- Login throttling ----------
CREATE TABLE IF NOT EXISTS login_attempts (
  id           BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email        VARCHAR(190) NOT NULL,
  ip_address   VARCHAR(45)  NOT NULL,
  success      TINYINT(1)   NOT NULL DEFAULT 0,
  attempted_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_email_time (email, attempted_at),
  INDEX idx_ip_time (ip_address, attempted_at)
) ENGINE=InnoDB;

-- ---------- Appointment enquiries ----------
CREATE TABLE IF NOT EXISTS appointments (
  id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  ref_no          VARCHAR(20)  NOT NULL UNIQUE,
  patient_name    VARCHAR(120) NOT NULL,
  mobile          VARCHAR(20)  NOT NULL,
  email           VARCHAR(190) NULL,
  age             TINYINT UNSIGNED NULL,
  department      VARCHAR(80)  NOT NULL,
  doctor          VARCHAR(120) NULL,
  preferred_date  DATE NULL,
  preferred_time  VARCHAR(40)  NULL,
  patient_type    ENUM('new','follow_up') NOT NULL DEFAULT 'new',
  message         TEXT NULL,
  status          ENUM('new','contacted','confirmed','completed','cancelled','follow_up')
                  NOT NULL DEFAULT 'new',
  assigned_to     VARCHAR(120) NULL,
  callback_date   DATE NULL,
  utm_source      VARCHAR(120) NULL,
  utm_medium      VARCHAR(120) NULL,
  utm_campaign    VARCHAR(120) NULL,
  ip_address      VARCHAR(45)  NULL,
  consent         TINYINT(1) NOT NULL DEFAULT 0,
  created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_status (status),
  INDEX idx_department (department),
  INDEX idx_pref_date (preferred_date),
  INDEX idx_created (created_at)
) ENGINE=InnoDB;

-- ---------- Appointment status history ----------
CREATE TABLE IF NOT EXISTS appointment_status_history (
  id             BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  appointment_id BIGINT UNSIGNED NOT NULL,
  old_status     VARCHAR(20) NULL,
  new_status     VARCHAR(20) NOT NULL,
  note           VARCHAR(255) NULL,
  changed_by     INT UNSIGNED NULL,
  created_at     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_ash_appointment FOREIGN KEY (appointment_id)
    REFERENCES appointments(id) ON DELETE CASCADE,
  INDEX idx_appt (appointment_id)
) ENGINE=InnoDB;

-- ---------- Internal notes on appointments ----------
CREATE TABLE IF NOT EXISTS admin_notes (
  id             BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  appointment_id BIGINT UNSIGNED NOT NULL,
  admin_id       INT UNSIGNED NULL,
  note           TEXT NOT NULL,
  created_at     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_notes_appointment FOREIGN KEY (appointment_id)
    REFERENCES appointments(id) ON DELETE CASCADE,
  INDEX idx_appt (appointment_id)
) ENGINE=InnoDB;

-- ---------- Contact enquiries ----------
CREATE TABLE IF NOT EXISTS contact_enquiries (
  id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name        VARCHAR(120) NOT NULL,
  email       VARCHAR(190) NULL,
  phone       VARCHAR(20)  NULL,
  department  VARCHAR(80)  NULL,
  subject     VARCHAR(160) NULL,
  message     TEXT NOT NULL,
  consent     TINYINT(1) NOT NULL DEFAULT 0,
  ip_address  VARCHAR(45) NULL,
  is_read     TINYINT(1) NOT NULL DEFAULT 0,
  created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_read (is_read),
  INDEX idx_created (created_at)
) ENGINE=InnoDB;

-- ---------- Insurance eligibility enquiries ----------
CREATE TABLE IF NOT EXISTS insurance_enquiries (
  id             BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name           VARCHAR(120) NOT NULL,
  mobile         VARCHAR(20)  NOT NULL,
  email          VARCHAR(190) NULL,
  insurer        VARCHAR(120) NULL,
  admission_type ENUM('planned','emergency','not_sure') NOT NULL DEFAULT 'not_sure',
  message        TEXT NULL,
  status         ENUM('new','contacted','closed') NOT NULL DEFAULT 'new',
  ip_address     VARCHAR(45) NULL,
  consent        TINYINT(1) NOT NULL DEFAULT 0,
  created_at     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_status (status)
) ENGINE=InnoDB;

-- ---------- Newsletter subscribers ----------
CREATE TABLE IF NOT EXISTS newsletter_subscribers (
  id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email      VARCHAR(190) NOT NULL UNIQUE,
  consent    TINYINT(1) NOT NULL DEFAULT 0,
  ip_address VARCHAR(45) NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------- Email logs ----------
CREATE TABLE IF NOT EXISTS email_logs (
  id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  to_email   VARCHAR(190) NOT NULL,
  subject    VARCHAR(255) NOT NULL,
  mail_type  VARCHAR(40)  NOT NULL,
  status     ENUM('sent','failed') NOT NULL,
  error      TEXT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_type (mail_type)
) ENGINE=InnoDB;

-- ---------- Admin audit log ----------
CREATE TABLE IF NOT EXISTS admin_audit_logs (
  id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  admin_id   INT UNSIGNED NULL,
  action     VARCHAR(80) NOT NULL,
  details    TEXT NULL,
  ip_address VARCHAR(45) NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_admin (admin_id),
  INDEX idx_action (action)
) ENGINE=InnoDB;

-- ---------- Settings (SMTP etc. — admin screen se manage) ----------
CREATE TABLE IF NOT EXISTS settings (
  skey   VARCHAR(80) NOT NULL PRIMARY KEY,
  svalue TEXT NULL
) ENGINE=InnoDB;

INSERT INTO settings (skey, svalue) VALUES
  ('smtp_host', ''),
  ('smtp_port', '587'),
  ('smtp_user', ''),
  ('smtp_pass', ''),
  ('smtp_secure', 'tls'),
  ('smtp_from_email', ''),
  ('smtp_from_name', 'Deccan Malti Hospital Website'),
  ('hospital_notify_email', '')
ON DUPLICATE KEY UPDATE svalue = VALUES(svalue);

-- NOTE: Pehla admin user /admin/setup.php se banayein (secure setup flow).
-- Production password kabhi bhi is file mein hard-code na karein.
