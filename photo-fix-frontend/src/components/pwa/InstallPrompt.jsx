import { useEffect, useState } from "react";
import { AnimatePresence, motion } from "framer-motion";

const DISMISS_KEY = "pgs.install.dismissed";

function alreadyInstalled() {
  return (
    window.matchMedia?.("(display-mode: standalone)").matches ||
    window.navigator.standalone === true
  );
}

/**
 * Native-style "Install app" sheet. Shows only when the browser fires
 * `beforeinstallprompt` (Chrome / Edge / Android), the app isn't already
 * installed, and the user hasn't dismissed it before.
 */
export function InstallPrompt() {
  const [deferred, setDeferred] = useState(null);
  const [open, setOpen] = useState(false);

  useEffect(() => {
    if (alreadyInstalled()) return;
    try {
      if (localStorage.getItem(DISMISS_KEY)) return;
    } catch {
      /* storage blocked — still fine to show */
    }

    const onPrompt = (e) => {
      e.preventDefault();
      setDeferred(e);
      setOpen(true);
    };
    const onInstalled = () => setOpen(false);

    window.addEventListener("beforeinstallprompt", onPrompt);
    window.addEventListener("appinstalled", onInstalled);
    return () => {
      window.removeEventListener("beforeinstallprompt", onPrompt);
      window.removeEventListener("appinstalled", onInstalled);
    };
  }, []);

  const dismiss = () => {
    setOpen(false);
    try {
      localStorage.setItem(DISMISS_KEY, "1");
    } catch {
      /* ignore */
    }
  };

  const install = async () => {
    if (!deferred) return;
    deferred.prompt();
    try {
      await deferred.userChoice;
    } finally {
      setDeferred(null);
      setOpen(false);
    }
  };

  return (
    <AnimatePresence>
      {open && (
        <motion.div
          initial={{ y: 120, opacity: 0 }}
          animate={{ y: 0, opacity: 1 }}
          exit={{ y: 120, opacity: 0 }}
          transition={{ type: "spring", stiffness: 380, damping: 32 }}
          className="fixed inset-x-0 bottom-0 z-[120] px-3 pb-[calc(0.75rem+env(safe-area-inset-bottom))] sm:left-auto sm:right-4 sm:max-w-sm"
          role="dialog"
          aria-label="Install app"
        >
          <div className="flex items-center gap-3 rounded-[var(--pfz-radius-lg)] border border-line bg-canvas p-3 shadow-[var(--pfz-shadow-card)]">
            <span className="grid h-11 w-11 shrink-0 place-items-center rounded-[var(--pfz-radius-md)] pfz-gradient-brand text-white">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                <rect x="3" y="5" width="18" height="14" rx="3" /><circle cx="12" cy="12" r="3.2" />
              </svg>
            </span>
            <div className="min-w-0 flex-1">
              <p className="text-sm font-bold text-heading">Install Pixel Graphic Studio</p>
              <p className="truncate text-xs text-muted">Add it to your home screen — opens full-screen, works offline.</p>
            </div>
            <button
              onClick={dismiss}
              className="shrink-0 rounded-md px-2 py-1 text-xs font-medium text-muted transition hover:text-heading"
            >
              Not now
            </button>
            <button
              onClick={install}
              className="shrink-0 rounded-[var(--pfz-radius-pill)] pfz-gradient-brand px-4 py-2 text-xs font-bold text-white"
            >
              Install
            </button>
          </div>
        </motion.div>
      )}
    </AnimatePresence>
  );
}
