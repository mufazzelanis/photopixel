import { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import { AnimatePresence, motion } from "framer-motion";

export function FloatingButtons() {
  const [show, setShow] = useState(false);

  useEffect(() => {
    const onScroll = () => setShow(window.scrollY > 500);
    window.addEventListener("scroll", onScroll, { passive: true });
    return () => window.removeEventListener("scroll", onScroll);
  }, []);

  return (
    <>
      {/* Back-to-top: chat-bubble shaped (rounded, one tighter corner for a
          "pointer"), bottom-left — kept apart from the quote button so the
          two don't compete for the same corner. */}
      <AnimatePresence>
        {show && (
          <motion.button
            initial={{ opacity: 0, scale: 0.6 }}
            animate={{ opacity: 1, scale: 1 }}
            exit={{ opacity: 0, scale: 0.6 }}
            onClick={() => window.scrollTo({ top: 0, behavior: "smooth" })}
            aria-label="Back to top"
            className="fixed bottom-4 left-4 z-40 grid h-11 w-11 place-items-center rounded-tl-full rounded-tr-full rounded-br-full rounded-bl-md bg-secondary text-white shadow-lg transition hover:-translate-y-0.5 sm:bottom-5 sm:left-5"
          >
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round"><path d="M6 15l6-6 6 6" /></svg>
          </motion.button>
        )}
      </AnimatePresence>

      <Link
        to="/free-trial"
        aria-label="Get a quote"
        className="group fixed bottom-4 right-4 z-40 grid h-14 w-14 place-items-center rounded-full pfz-gradient-cta text-white shadow-[var(--pfz-shadow-glow)] transition hover:scale-105 sm:bottom-5 sm:right-5"
      >
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
          <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
        </svg>
      </Link>
    </>
  );
}
