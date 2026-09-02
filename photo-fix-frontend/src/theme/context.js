import { createContext, useContext } from "react";

export const ThemeCtx = createContext(null);

export function useSite() {
  const ctx = useContext(ThemeCtx);
  if (!ctx) throw new Error("useSite must be used within <ThemeProvider>");
  return ctx;
}

/** Map a section `settings.bg` key to a background class. */
export function bgClass(key) {
  switch (key) {
    case "bg-alt":
      return "bg-alt";
    case "bg-soft":
      return "bg-soft";
    case "bg-dark":
      return "pfz-gradient-dark text-white";
    case "gradient-brand":
      return "pfz-gradient-brand text-white";
    case "gradient-cta":
      return "pfz-gradient-cta text-white";
    case "gradient-hero":
      return "pfz-gradient-hero";
    default:
      return "bg-canvas";
  }
}
