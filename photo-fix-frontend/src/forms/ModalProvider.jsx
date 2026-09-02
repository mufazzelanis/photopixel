/* eslint-disable react-refresh/only-export-components -- context + co-located hooks by design */
import { createContext, useCallback, useContext, useState } from "react";
import { Modal } from "../components/ui/Modal";
import { QuoteForm } from "./QuoteForm";
import { FreeTrialForm } from "./FreeTrialForm";

const ModalCtx = createContext(null);

export function ModalProvider({ children }) {
  const [view, setView] = useState(null); // 'quote' | 'trial' | null

  const openQuote = useCallback(() => setView("quote"), []);
  const openFreeTrial = useCallback(() => setView("trial"), []);
  const close = useCallback(() => setView(null), []);

  return (
    <ModalCtx.Provider value={{ openQuote, openFreeTrial, close }}>
      {children}
      <Modal open={view === "quote"} onClose={close} title="Get a free quote" wide>
        <QuoteForm onDone={close} />
      </Modal>
      <Modal open={view === "trial"} onClose={close} title="Try 5 images for free">
        <FreeTrialForm onDone={close} />
      </Modal>
    </ModalCtx.Provider>
  );
}

export const useModal = () => {
  const ctx = useContext(ModalCtx);
  if (!ctx) throw new Error("useModal must be used within <ModalProvider>");
  return ctx;
};

/**
 * Resolve an href/url from the CMS into an action:
 * "#quote" goes to the /free-trial page (not a modal — every "Get a Quote"
 * entry point sitewide funnels here); "#free-trial" still opens the quick
 * modal; "#id" scrolls; anything else is a link.
 */
export function useCmsAction() {
  const { openFreeTrial } = useModal();
  return useCallback(
    (url) => {
      if (!url) return { type: "none" };
      if (url === "#quote") return { type: "route", to: "/free-trial" };
      if (url === "#free-trial") return { type: "action", run: openFreeTrial };
      if (url.startsWith("#")) return { type: "anchor", to: url };
      if (url.startsWith("http")) return { type: "external", to: url };
      return { type: "route", to: url };
    },
    [openFreeTrial],
  );
}
