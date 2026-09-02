import { useState } from "react";
import { AnimatePresence, motion } from "framer-motion";

export function Accordion({ items = [] }) {
  const [open, setOpen] = useState(0);

  return (
    <div className="mx-auto max-w-3xl space-y-3">
      {items.map((item, i) => {
        const isOpen = open === i;
        return (
          <div
            key={i}
            className="overflow-hidden rounded-[var(--pfz-radius-md)] border border-line bg-canvas"
          >
            <button
              type="button"
              onClick={() => setOpen(isOpen ? -1 : i)}
              className="flex w-full items-center justify-between gap-4 px-5 py-4 text-left font-semibold text-heading"
              aria-expanded={isOpen}
            >
              <span>
                {i + 1}. {item.question}
              </span>
              <svg
                className={"shrink-0 transition-transform duration-300 " + (isOpen ? "rotate-180" : "")}
                width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round"
                aria-hidden="true"
              >
                <path d="M6 9l6 6 6-6" />
              </svg>
            </button>
            <AnimatePresence initial={false}>
              {isOpen && (
                <motion.div
                  initial={{ height: 0, opacity: 0 }}
                  animate={{ height: "auto", opacity: 1 }}
                  exit={{ height: 0, opacity: 0 }}
                  transition={{ duration: 0.28, ease: [0.22, 1, 0.36, 1] }}
                >
                  <div
                    className="px-5 pb-5 text-muted leading-relaxed [&_a]:text-primary [&_a]:underline"
                    dangerouslySetInnerHTML={{ __html: item.answer }}
                  />
                </motion.div>
              )}
            </AnimatePresence>
          </div>
        );
      })}
    </div>
  );
}
