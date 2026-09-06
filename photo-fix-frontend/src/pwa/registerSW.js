/**
 * Registers /sw.js in production. When a new version is found it activates
 * immediately and reloads once so the user is never stuck on a stale build.
 */
export function registerSW() {
  if (!("serviceWorker" in navigator)) return;

  // Dev mode must never run under a service worker — if one is still
  // installed from an earlier production build/preview on this same
  // origin (localhost:5173), it silently serves stale cached JS/CSS
  // forever, no matter what actually changes on disk. Nuke it here so a
  // plain reload self-heals instead of needing manual DevTools surgery.
  if (!import.meta.env.PROD) {
    navigator.serviceWorker.getRegistrations().then((regs) => {
      regs.forEach((r) => r.unregister());
    });
    if (window.caches?.keys) {
      window.caches.keys().then((keys) => keys.forEach((k) => window.caches.delete(k)));
    }
    return;
  }

  window.addEventListener("load", () => {
    navigator.serviceWorker
      .register("/sw.js", { scope: "/" })
      .then((reg) => {
        // A waiting worker means an update is ready — take over at once.
        const promote = (worker) => {
          if (!worker) return;
          worker.addEventListener("statechange", () => {
            if (worker.state === "installed" && navigator.serviceWorker.controller) {
              worker.postMessage("SKIP_WAITING");
            }
          });
        };
        if (reg.waiting) reg.waiting.postMessage("SKIP_WAITING");
        reg.addEventListener("updatefound", () => promote(reg.installing));
      })
      .catch(() => {
        /* offline on first load, or SW unsupported — the app still works online */
      });

    let refreshing = false;
    navigator.serviceWorker.addEventListener("controllerchange", () => {
      if (refreshing) return;
      refreshing = true;
      window.location.reload();
    });
  });
}
