# Deploying Pixel Graphic Studio to pixelgraphicstudio.com (cPanel)

Recommended layout: the React site lives on the **root domain**
(`pixelgraphicstudio.com`), the Laravel API + admin panel live on a
**subdomain** (`api.pixelgraphicstudio.com`). This is the simplest and most
reliable setup on shared hosting — no Node.js process needs to run live, the
frontend is just static files.

---

## 0) First — check what your cPanel gives you

Log into cPanel and look for an icon called **"Terminal"** (under Advanced).
If it's there, you have command-line access and steps 3–6 below go much
faster. If it's not there, every step below also has a no-terminal fallback.

---

## 1) Create the API subdomain

cPanel → **Subdomains** → create `api` → domain `pixelgraphicstudio.com`.
When it asks for a **Document Root**, do NOT accept the default
(`public_html/api`). Instead point it somewhere *outside* public_html, e.g.
`api_app/public` — this keeps your Laravel code (config, .env, database
credentials) outside the web-servable folder, which is important for
security. If your host's Subdomains form won't let you pick a custom root,
tell me and I'll give you the alternate (in-public_html) layout instead.

## 2) Create the database

cPanel → **MySQL Databases**:
- Create a database (e.g. `photopixel`) — cPanel will prefix it, e.g.
  `youruser_photopixel`.
- Create a database user + strong password.
- Add that user to that database with **All Privileges**.
- Write down: DB name, DB username, DB password — you'll need them in step 5.

## 3) Upload the backend (`photo-fix-backend`)

**With Terminal:**
```bash
cd ~/api_app          # the folder you pointed the subdomain's public/ into
git clone <your repo url> .      # or upload+extract a zip of photo-fix-backend
composer install --no-dev --optimize-autoloader
```

**Without Terminal:** run `composer install --no-dev --optimize-autoloader`
right here on your own machine first (I can do this for you), then zip the
whole `photo-fix-backend` folder **including the generated `vendor/` folder**
and upload+extract it via cPanel File Manager. The vendor folder is large
(~100MB) — that's normal, it's every PHP library Laravel needs.

## 4) Create `.env` on the server

Copy `photo-fix-backend/.env.production.example` (already prepared with your
domain) to `.env` on the server, then fill in the `CHANGE_ME` values with
the DB credentials from step 2 and email credentials from cPanel → Email
Accounts (create `office@pixelgraphicstudio.com` first if you don't have one).

## 5) Run the setup commands

**With Terminal**, from the `api_app` folder:
```bash
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan optimize
```

**Without Terminal:** these need to run once on the server — either ask your
host's support to run them for you (a normal, common request), or check if
your host offers a "Setup PHP App" / cron-once trick. Tell me which you'd
prefer and I'll write exact instructions for it.

⚠️ **After `db:seed` runs on the live server, immediately log into
`https://api.pixelgraphicstudio.com/admin` with `admin@pixelgraphicstudio.com`
/ the password I gave you earlier, and change the password** — the seeded
one should never stay live long-term.

## 6) Build and upload the frontend (`photo-fix-frontend`)

This part happens **on your own computer** (this XAMPP machine), not the
server — the build step needs Node, which shared hosting usually can't run
persistently:

```bash
cd photo-fix-frontend
npm run build
```

This produces a `dist/` folder. Upload **the contents of `dist/`** (not the
folder itself — the files *inside* it) to `public_html` for the main domain
`pixelgraphicstudio.com`, via cPanel File Manager or FTP.

## 7) SSL

cPanel → **SSL/TLS Status** (or "Let's Encrypt™ SSL" / AutoSSL) → run it for
both `pixelgraphicstudio.com` and `api.pixelgraphicstudio.com`. Do this
*after* the subdomain exists. Free, usually auto-renews.

## 8) Final check

Visit `https://pixelgraphicstudio.com` — homepage should load with real
data. Visit `https://api.pixelgraphicstudio.com/admin` — admin login should
appear. Submit a test Quote/Contact form and confirm you receive the email.

---

### Whenever you update content only (no code changes)
Nothing to redeploy — the admin panel edits the live database directly.

### Whenever the code changes (bug fix, new feature)
- Backend: re-upload changed files, then run `php artisan optimize` again.
- Frontend: `npm run build` again, re-upload the new `dist/` contents.
