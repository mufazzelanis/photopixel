import { useEffect, useRef, useState } from "react";
import { Link } from "react-router-dom";
import { AnimatePresence, motion } from "framer-motion";
import { useSite } from "../../theme/context";
import { Icon } from "../../lib/Icon";
import { prefersReducedMotion } from "../../lib/utils";

/** Brand colours for the round channel buttons. */
const BRAND = {
  whatsapp: "#25D366",
  telegram: "#26A5E4",
  messenger: "#0084FF",
  wechat: "#07C160",
  viber: "#7360F2",
  facebook: "#1877F2",
  linkedin: "#0A66C2",
  instagram: "#E1306C",
  x: "#111111",
  twitter: "#111111",
  youtube: "#FF0000",
  discord: "#5865F2",
  tiktok: "#111111",
  pinterest: "#E60023",
  phone: "#16A34A",
  mail: "#6C4CF1",
  star: "#00B67A",
};

/**
 * Floating chat / social launcher, bottom-right.
 *
 * Collapsed → a single FAB. Tapped → the enabled channels fan out upward with a
 * staggered spring; each opens its link. Which channels appear (and whether the
 * whole thing is on) is set in the admin: Settings → Social Links → "Widget"
 * and Settings → General → Chat Widget.
 */
export function FloatingSocial() {
  const { data, animation } = useSite();
  const w = data?.contact_widget;
  const reduce = animation?.respect_reduced_motion && prefersReducedMotion();

  const [open, setOpen] = useState(false);
  const rootRef = useRef(null);

  useEffect(() => {
    if (!open) return;
    const onKey = (e) => e.key === "Escape" && setOpen(false);
    const onPointer = (e) => {
      if (rootRef.current && !rootRef.current.contains(e.target)) setOpen(false);
    };
    window.addEventListener("keydown", onKey);
    window.addEventListener("pointerdown", onPointer);
    return () => {
      window.removeEventListener("keydown", onKey);
      window.removeEventListener("pointerdown", onPointer);
    };
  }, [open]);

  if (!w?.enabled) return null;

  const channels = Array.isArray(w.channels) ? w.channels : [];
  if (!channels.length && !w.show_free_trial) return null;

  const items = [
    ...(w.show_free_trial
      ? [{ key: "free-trial", label: "Free Trial", to: "/free-trial", color: "var(--pfz-color-primary)", icon: "gift" }]
      : []),
    ...channels.map((c) => ({
      key: c.platform,
      label: c.platform,
      href: c.url,
      color: BRAND[(c.icon || "").toLowerCase()] || "var(--pfz-color-primary)",
      icon: c.icon,
    })),
  ];

  const spring = reduce ? { duration: 0 } : { type: "spring", stiffness: 430, damping: 28 };

  return (
    <>
      {/* dim layer on small screens so the fan-out reads clearly */}
      <AnimatePresence>
        {open && (
          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
            transition={{ duration: 0.2 }}
            onClick={() => setOpen(false)}
            className="fixed inset-0 z-40 bg-heading/30 backdrop-blur-[1px] sm:hidden"
            aria-hidden="true"
          />
        )}
      </AnimatePresence>

      <div
        ref={rootRef}
        className="pfz-safe-bottom fixed right-4 z-50 flex flex-col items-end gap-3 sm:right-5"
      >
        <AnimatePresence>
          {open && (
            <motion.ul
              initial={reduce ? { opacity: 0 } : false}
              animate={{ opacity: 1 }}
              exit={reduce ? { opacity: 0 } : { opacity: 1 }}
              className="flex flex-col items-end gap-2.5"
            >
              {items.map((it, i) => {
                const delay = reduce ? 0 : (items.length - 1 - i) * 0.035;
                const body = (
                  <>
                    <span className="pointer-events-none translate-x-1 rounded-full bg-heading/90 px-2.5 py-1 text-xs font-semibold text-white opacity-0 shadow-md backdrop-blur transition group-hover:translate-x-0 group-hover:opacity-100">
                      {it.label}
                    </span>
                    <span
                      className="grid h-11 w-11 shrink-0 place-items-center rounded-full text-white shadow-lg ring-1 ring-black/5 transition group-hover:scale-110"
                      style={{ backgroundColor: it.color }}
                    >
                      <Icon name={it.icon} size={19} />
                    </span>
                  </>
                );
                const cls = "group flex items-center gap-2.5";
                return (
                  <motion.li
                    key={it.key}
                    initial={reduce ? false : { opacity: 0, y: 14, scale: 0.5 }}
                    animate={{ opacity: 1, y: 0, scale: 1, transition: { ...spring, delay } }}
                    exit={reduce ? { opacity: 0 } : { opacity: 0, y: 14, scale: 0.5, transition: { duration: 0.12 } }}
                  >
                    {it.to ? (
                      <Link to={it.to} className={cls} onClick={() => setOpen(false)} aria-label={it.label}>
                        {body}
                      </Link>
                    ) : (
                      <a
                        href={it.href}
                        target="_blank"
                        rel="noopener noreferrer"
                        className={cls}
                        onClick={() => setOpen(false)}
                        aria-label={it.label}
                      >
                        {body}
                      </a>
                    )}
                  </motion.li>
                );
              })}
            </motion.ul>
          )}
        </AnimatePresence>

        <button
          type="button"
          onClick={() => setOpen((v) => !v)}
          aria-label={w.label || "Contact us"}
          aria-expanded={open}
          className="grid h-14 w-14 place-items-center rounded-full pfz-gradient-cta text-white shadow-[var(--pfz-shadow-glow)] transition hover:scale-105"
        >
          <motion.span
            animate={{ rotate: open ? 90 : 0 }}
            transition={spring}
            className="grid place-items-center"
          >
            {open ? (
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.4" strokeLinecap="round" strokeLinejoin="round">
                <path d="M6 6l12 12M18 6L6 18" />
              </svg>
            ) : (
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
              </svg>
            )}
          </motion.span>
        </button>
      </div>
    </>
  );
}
