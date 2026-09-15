// Runs automatically before every `npm run build` (npm's "prebuild" lifecycle
// hook). Stamps public/sw.js with a fresh CACHE_VERSION so every deploy
// forces returning visitors' browsers onto the new build.
//
// Why this matters: the service worker's static-asset strategy is
// stale-while-revalidate — it serves whatever's already cached immediately,
// then refetches in the background only to update the cache for *next* time.
// Vite content-hashes every JS/CSS filename, and deploys here replace the
// whole `assets/` folder, so an old cached chunk's URL stops existing on the
// server. That background refetch then just 404s forever, silently, and the
// browser keeps serving the stale (and now orphaned) chunk indefinitely —
// exactly the "couldn't reach server" symptom this was shipped to prevent.
// A fresh CACHE_VERSION on each build makes the service worker's own
// `activate` handler purge every old cache and start clean.
import { readFileSync, writeFileSync } from "node:fs";
import { fileURLToPath } from "node:url";
import path from "node:path";

const swPath = path.join(path.dirname(fileURLToPath(import.meta.url)), "..", "public", "sw.js");
const version = `pgs-${Date.now()}`;

const contents = readFileSync(swPath, "utf8");
const updated = contents.replace(
  /const CACHE_VERSION = "[^"]*";/,
  `const CACHE_VERSION = "${version}";`,
);

if (updated === contents) {
  throw new Error(`Could not find CACHE_VERSION line in ${swPath} — sw.js format changed?`);
}

writeFileSync(swPath, updated);
console.log(`sw.js CACHE_VERSION -> ${version}`);
