# Engineer Jules — Portfolio Website

A complete PHP + MySQL portfolio website with a custom admin CMS, built for
XAMPP / local development and easy deployment to any standard PHP host.

## Tech Stack

- PHP 8+ (no framework — plain PHP with a light MVC-style structure)
- MySQL (PDO with prepared statements)
- HTML5 / CSS3 (custom design system, no Tailwind build step required)
- Vanilla JavaScript

## Folder Structure

```
engineer-jules/
├── public/              ← Web root for the PUBLIC site (point Apache here)
│   ├── index.php        ← Homepage
│   ├── about.php
│   ├── services.php
│   ├── projects.php
│   ├── project-details.php
│   ├── contact.php
│   └── assets/          ← CSS, JS, uploaded project images
├── admin/               ← Admin CMS (separate mini-app)
│   ├── login.php
│   ├── index.php        ← Dashboard
│   ├── projects.php / project-form.php
│   ├── services.php / service-form.php
│   ├── messages.php
│   ├── settings.php
│   ├── users.php
│   └── assets/css/admin.css
├── config/              ← DB connection, global config, helper functions
├── models/              ← Project, Service, Message, Settings, User
├── views/partials/      ← Shared header/footer for the public site
├── database/
│   ├── schema.sql              ← Full schema + seed data
│   └── generate_admin_hash.php ← Run once to set a working admin password
├── uploads/             ← Reserved for future user uploads (PHP execution blocked)
└── controllers/         ← Reserved for future expansion
```

## Setup (XAMPP)

1. **Copy the project** into your `htdocs` folder, e.g.:
   `C:\xampp\htdocs\engineer-jules\` or `/Applications/XAMPP/htdocs/engineer-jules/`

2. **Create the database.**
   Open phpMyAdmin → Import → select `database/schema.sql`.
   This creates the `engineer_jules_portfolio` database with all tables and
   seed data (3 sample projects, 6 services, default settings).

3. **Set the admin password.**
   The schema inserts a placeholder password hash that will NOT log in as-is.
   Visit this once in your browser:

   ```
   http://localhost/engineer-jules/database/generate_admin_hash.php
   ```

   Copy the SQL it prints and run it in phpMyAdmin (SQL tab). This sets the
   admin login to:
   - **Email:** `admin@engineerjules.com`
   - **Password:** `Admin@123`

   **Then delete `database/generate_admin_hash.php`** — it should never stay
   on a live server.

4. **Check `config/config.php`.**
   `BASE_URL` and `ADMIN_URL` default to `/engineer-jules/public` and
   `/engineer-jules/admin`. If you named your folder differently, update
   these two constants to match.

5. **Check `config/database.php`** if your MySQL user/password differ from
   the XAMPP defaults (`root` / empty password).

6. **Visit the site:**
   - Public site: `http://localhost/engineer-jules/public/index.php`
   - Admin login: `http://localhost/engineer-jules/admin/login.php`

## Admin Panel

From the dashboard you can:

- **Projects** — add, edit, delete; upload a thumbnail image; set the GitHub
  link and live demo link per project (this is how you change the fake
  GitHub placeholder links to your real ones); mark a project "featured" to
  show it on the homepage.
- **Services** — add/edit/delete the service cards shown on the Services page.
- **Messages** — view and manage messages submitted through the Contact form.
- **Site Settings** — change the site name, hero headline/subtitle, contact
  email, WhatsApp number, and GitHub profile link — these update instantly
  across the whole public site (navbar, footer, floating WhatsApp button,
  contact page).
- **Users** — add or remove additional admin accounts.

## Security Notes

- All database queries use PDO prepared statements.
- All forms are protected with CSRF tokens (`csrf_field()` / `verify_csrf()`).
- Passwords are hashed with PHP's `password_hash()` (bcrypt).
- Output is escaped with `e()` (a `htmlspecialchars` wrapper) to prevent XSS.
- Sessions use `httponly`, `SameSite=Lax` cookies and are regenerated on login.
- The `/uploads` folder has a `.htaccess` blocking PHP execution.
- **Before deploying to production:** change the default admin password,
  delete `database/generate_admin_hash.php`, set `display_errors` to `0` in
  `config/config.php`, and switch to HTTPS (set `session.cookie_secure`).

## Customizing

- **Colors, type, spacing:** all in `public/assets/css/style.css` as CSS
  custom properties at the top of the file (`:root` and `[data-theme="light"]`).
- **Hero terminal animation:** `public/assets/js/main.js` — edit the `script`
  array to change what types out in the homepage terminal mockup.
- **Project images:** upload through the admin panel, or drop files directly
  into `public/assets/images/` and reference the filename in a project's
  "Gallery Filenames" field.
