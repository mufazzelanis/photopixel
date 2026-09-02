# Photo Fix Zone — Frontend (React + Vite + Tailwind v4)

Marketing site for Photo Fix Zone. All content, colours and animation come from
the Laravel API (`photo-fix-backend`) — nothing on this page is hard-coded except
layout.

## Run

```bash
npm install
cp .env .env.local   # or edit .env
npm run dev          # http://localhost:5173
```

`.env`:

```
VITE_API_URL=http://localhost:8000/api/v1
```

The backend must be running (`php artisan serve` in `photo-fix-backend`) and its
`FRONTEND_ORIGINS` must include this dev origin (already set to :5173).

## How theming works

`ThemeProvider` calls `GET /api/v1/home`, then writes the theme tokens as
`--pfz-*` CSS custom properties on `:root`. `src/index.css` maps Tailwind's
theme namespace to those vars with `@theme inline`, so changing a colour in the
admin **Appearance** page re-skins the whole site with no rebuild.

## Structure

| Path | What |
|---|---|
| `src/theme/ThemeProvider.jsx` | fetch payload, inject CSS vars, expose animation config |
| `src/components/sections/*` | one component per homepage block |
| `src/pages/Home.jsx` | renders `sections[]` from the API in admin-defined order |
| `src/components/ui/*` | Reveal, Section, Button, Carousel, BeforeAfter, Counter … |
| `src/forms/*` | Quote / Contact / Free-trial / Newsletter (react-hook-form + zod) |
| `src/lib/Icon.jsx` | icon-key → SVG map (keys are set in the admin) |

## Build

```bash
npm run build      # -> dist/  (deploy to any static host)
```
