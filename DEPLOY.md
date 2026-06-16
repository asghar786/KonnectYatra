# Going Live — KonnectYatra (cPanel + GitHub Actions)

Push to `main` on GitHub → GitHub Actions SSHes into the cPanel server, pulls the
code, installs Composer deps, and rebuilds Laravel caches. One-time setup below.

Target: **https://www.konnectyatra.org** • PHP 8.0 (ea-php80) • MySQL.

---

## 0. Back up the OLD server first (before deleting anything)

- cPanel → **File Manager** → compress `public_html` → download the zip.
- cPanel → **phpMyAdmin** → export the old database (`.sql`).
- Copy the old `public_html/.env` somewhere safe (may hold `APP_KEY`, mail, payment keys).

Then delete the old `public_html` contents and create the new database.

## 1. Create the production database (cPanel → MySQL Databases)

1. Create DB (e.g. `cpuser_konnectyatra`).
2. Create a DB user + strong password.
3. Add the user to the DB with **ALL PRIVILEGES**.
4. Note the final names — cPanel prefixes them with your account (`cpuser_...`).

## 2. Import your local data

On your Windows machine (Git Bash):

```bash
/c/xampp/mysql/bin/mysqldump.exe -u root konnectyatra > konnectyatra.sql
```

Then on the server: cPanel → phpMyAdmin → select the new DB → **Import** → upload
`konnectyatra.sql`. (For large files use Terminal: `mysql -u cpuser_konnectyatra -p cpuser_konnectyatra < konnectyatra.sql`.)

> Because the schema comes from this dump, **do not run `php artisan migrate`** on the
> fresh DB — the tables already exist. New migrations later: `php artisan migrate --path=database/migrations/<file>.php`.

## 3. Clone the repo on the server (cPanel Terminal)

```bash
cd ~
git clone https://github.com/asghar786/KonnectYatra.git konnectyatra
cd konnectyatra
```

If the repo is private, use a deploy key or a GitHub token in the clone URL.

## 4. Point the domain's document root at `public/`

**Preferred:** cPanel → **Domains** → edit `konnectyatra.org` document root →
`/home/<cpuser>/konnectyatra/public`.

**If the docroot is locked to `public_html`** (common for the primary domain), symlink it:

```bash
rm -rf ~/public_html
ln -s ~/konnectyatra/public ~/public_html
```

Either way, the web root is the repo's `public/` folder — app code stays out of the web root.

## 5. Create the production `.env` on the server

In `~/konnectyatra`, create `.env` (it is gitignored — never committed). Use the
contents Claude provides in chat, with these production values:

```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://www.konnectyatra.org
# No ASSET_URL needed — docroot is public/, assets resolve at the domain root.

DB_DATABASE=cpuser_konnectyatra
DB_USERNAME=cpuser_dbuser
DB_PASSWORD=********
```

Keep the existing `APP_KEY` (reuse it; don't regenerate, or you'll invalidate any
encrypted data). Then:

```bash
/opt/cpanel/ea-php80/root/usr/bin/php artisan config:cache
```

## 6. First install (one time, in Terminal)

```bash
cd ~/konnectyatra
composer install --no-dev --optimize-autoloader
/opt/cpanel/ea-php80/root/usr/bin/php artisan storage:link || true
chmod -R 775 storage bootstrap/cache
```

Visit https://www.konnectyatra.org — the site should load. Test admin login at `/admin_login`.

## 7. Wire up auto-deploy (GitHub Actions over SSH)

1. cPanel → **SSH Access** → enable; note host, **port** (often `21098`, sometimes `22`), and username.
2. Generate a deploy keypair locally:
   ```bash
   ssh-keygen -t ed25519 -f konnectyatra_deploy -N ""
   ```
3. Add the **public** key (`konnectyatra_deploy.pub`) to the server:
   cPanel → SSH Access → Manage SSH Keys → Import (or append to `~/.ssh/authorized_keys`).
4. In GitHub → repo **Settings → Secrets and variables → Actions** → add:
   - `SSH_HOST` — server hostname or IP
   - `SSH_USERNAME` — cPanel username
   - `SSH_PORT` — e.g. `21098`
   - `SSH_PRIVATE_KEY` — full contents of `konnectyatra_deploy` (the private file)
5. The workflow [.github/workflows/deploy.yml](.github/workflows/deploy.yml) runs on
   every push to `main`. Trigger a manual test run from the **Actions** tab → *Deploy to cPanel* → *Run workflow*.

> Edit `APP_DIR` / `PHP` paths at the top of the workflow if your server differs.
> The workflow does **not** run migrations (see step 2 note).

## 8. After it's live

- Set `APP_DEBUG=false` (already set) and confirm no Laravel debug page shows on errors.
- Confirm mail sends (test the contact/booking flow).
- Optional: schedule Laravel cron if the app uses scheduled tasks
  (`* * * * * /opt/cpanel/ea-php80/root/usr/bin/php ~/konnectyatra/artisan schedule:run >> /dev/null 2>&1`).
