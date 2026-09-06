# Fresh clone / new machine setup

Run these from `photo-fix-backend/` after `git pull`. `.env`, the `vendor/`
folder, the storage symlink and the temp-upload folder are **not** in git, so a
new machine needs them created once.

Quickest path — one command does the lot:

```bash
composer setup   # install + .env + key + migrate + storage:link + optimize:clear + npm build
```

Or step by step:

```bash
composer install              # its post-autoload-dump hook auto-runs config:clear + storage:link

cp .env.example .env          # first time only
php artisan key:generate      # first time only
php artisan migrate --seed    # or: php artisan migrate:fresh --seed
php artisan optimize:clear
```

**After every `git pull`, just run `composer install`** — the hook clears the
config cache, so the upload fix below can never be shadowed by a stale cache.
(If you skip composer, run `php artisan config:clear` yourself.)

Then start the API:

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

## `.env` must-haves

| key | value | why |
|-----|-------|-----|
| `APP_KEY` | a generated key | sessions / CSRF break without it → uploads 419 |
| `APP_URL` | the exact scheme+host+port you open the admin on | keep it consistent (`http://127.0.0.1:8000` **or** `http://localhost:8000`, not mixed) |
| `SESSION_DRIVER` | `database` | table is migrated by `migrate` |
| `FILESYSTEM_DISK` | `local` | |

## If the image uploader spins on "Loading / Waiting for size"

This is the Laravel 11+/Filament FilePond bug. It is already fixed in config:

- `config/filesystems.php` → local disk `'serve' => false`
  (stops uploads going through a signed cross-origin `PUT /storage/...` URL)
- `config/livewire.php` → `temporary_file_upload.disk` pinned to `local`
- `config/cors.php` → `livewire/*` and `storage/*` added to `paths`

After pulling, run `php artisan optimize:clear`, restart `php artisan serve`,
and hard-reload the admin tab (Ctrl+Shift+R) so the old Livewire JS is dropped.

Open the admin at the **same host** as `APP_URL`.
