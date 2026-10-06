# DEPLOYMENT GUIDE — Deccan Malti Hospital Website (Shared Hosting / cPanel / Hostinger)

Step-by-step, zero technical jargon. ~20–30 minutes total.

---

## STEP 1 — ZIP upload karo

1. `deccan-malti-hospital.zip` ko `public_html` (ya apne domain ke folder) me upload karo — cPanel → **File Manager** → Upload. Hostinger: **hPanel → File Manager**.
2. ZIP par right-click → **Extract**.
3. Extract ke baad check karo ki `index.php`, `.htaccess`, `database.sql` directly `public_html` ke andar hon — `public_html/deccan-malti-hospital/index.php` nahi. Agar subfolder me extract hua hai, sab files select karke `public_html` me **Move** karo.
4. File Manager me "Show Hidden Files" on karke confirm karo ki `.htaccess` bhi aayi hai.

## STEP 2 — Database banao

1. cPanel → **MySQL® Databases** (Hostinger: **Databases → MySQL**).
2. **New Database**: e.g. `dmh_db` → Create.
3. **Add New User**: e.g. `dmh_user` + strong password (password kahin save kar lo).
4. **Add User to Database**: dono select → Add → **ALL PRIVILEGES** → Make Changes.

## STEP 3 — database.sql import karo

1. cPanel → **phpMyAdmin**.
2. Left side se apni database (`dmh_db`) select karo.
3. Upar **Import** tab → Choose File → `database.sql` → **Go/Import**.
4. Success message ke baad left side me tables dikhenge: `admin_users`, `appointments`, `contact_enquiries`, `insurance_enquiries`, `newsletter_subscribers`, etc. — 10 tables.
5. Import ke baad `database.sql` ko server se **delete** kar sakte ho (security hygiene).

## STEP 4 — config.php banao

1. File Manager me `config/` folder kholo.
2. `config.example.php` ki copy banao → rename to `config.php`.
3. `config.php` edit karo:

```php
define('DB_HOST', 'localhost');         // 99% shared hosting par yehi hota hai
define('DB_NAME', 'cpaneluser_dmh_db'); // phpMyAdmin me jo naam dikha
define('DB_USER', 'cpaneluser_dmh_user');
define('DB_PASS', 'JO_PASSWORD_BANAYA');
define('SITE_URL', 'https://yourdomain.in'); // apna domain, no trailing slash
define('APP_ENV', 'production');
```

> cPanel/Hostinger me DB name/user ke aage `cpanelusername_` prefix lagta hai — phpMyAdmin me exact naam copy karo.

## STEP 5 — Pehla admin account banao

1. Browser me kholo: `https://yourdomain.in/admin/setup.php`
2. Email + strong password (min 10 chars) daalo → **Create Admin**.
3. Ho gaya! Ye page ab **permanently closed** hai (koi bhi dobara nahi khol sakta).
4. Ab login karo: `https://yourdomain.in/admin/`

## STEP 6 — Email (SMTP) set karo — optional but recommended

Iske bina site chalega, par enquiry emails nahi aayengi.

1. Admin panel → **Settings**.
2. Apne hosting/email provider ke SMTP details daalo:
   - **Hostinger email**: host `smtp.hostinger.com`, port `465`, encryption `ssl`
   - **cPanel email**: host `mail.yourdomain.in`, port `465`, `ssl` (ya `587` + `tls`)
   - Username: poora email (e.g. `info@yourdomain.in`), Password: us email ka password
3. **Notify Email**: jis email par enquiry notifications chahiye.
4. **Send Test Email** button se verify karo.

> Agar email nahi ja raha: port/encryption swap karke try karo (465/ssl ↔ 587/tls). Kuch hosts outbound SMTP block karte hain — unse `mail.yourdomain.in` SMTP use karwao.

## STEP 7 — SSL (HTTPS)

1. cPanel → **SSL/TLS Status** → Run AutoSSL (free Let's Encrypt), ya Hostinger: **Security → SSL → Install**.
2. `.htaccess` already har visitor ko HTTPS par force karta hai — kuch karne ki zaroorat nahi.

## STEP 8 — Final checks

- [ ] Homepage khulta hai, departments/doctors pages chal rahe hain
- [ ] Appointment form submit karne par admin dashboard me entry aati hai
- [ ] Test email Settings se aa rahi hai
- [ ] `robots.txt` aur `sitemap.php` me domain update karo (`example.com` → apna domain), sitemap Google Search Console me submit karo
- [ ] `APP_ENV` = `production` hai (errors visitors ko nahi dikhenge)
- [ ] Logo/favicon OG image sahi dikh rahe hain

## Agar kuch toot jaye

| Problem | Fix |
|---|---|
| "Database connection is not configured" | `config/config.php` ke DB_* credentials check karo |
| 404 on inner pages (home chalta hai) | `.htaccess` upload hua? "Show hidden files" check karo; hosting par `mod_rewrite` on hona chahiye (sab standard hosts par hota hai) |
| 500 error | `APP_ENV` ko temporarily `'development'` karke actual error dekho |
| Emails nahi ja rahe | Settings me SMTP recheck; 465/ssl try karo; host support se poochho |
| Admin login bhool gaye | phpMyAdmin → `admin_users` → delete row → `/admin/setup.php` dobara active ho jayega |

---

**That's it.** Koi Composer, koi `npm`, koi build step nahi — pure PHP + MySQL, jaise upload kiya waise chalta hai.
