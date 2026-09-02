import { useEffect, useMemo, useState } from "react";
import { getHome } from "../api/endpoints";
import { ThemeCtx } from "./context";

const FALLBACK_ANIM = {
  enabled: true,
  respect_reduced_motion: true,
  reveal: { type: "fade-up", duration: 0.6, distance: 32, stagger: 0.08, once: true },
  hero: { animated_gradient: true, float: true, parallax: true, heading_stagger: true },
  counters: true,
  carousel_autoplay: true,
  autoplay_delay: 4000,
  page_transition: true,
  hover_lift: true,
};

/** Flatten { color: { primary: '#fff' } } -> { '--pfz-color-primary': '#fff' } */
function toCssVars(tokens) {
  const out = {};
  const walk = (obj, prefix) => {
    for (const [k, v] of Object.entries(obj ?? {})) {
      const key = `${prefix}-${k}`;
      if (v && typeof v === "object" && !Array.isArray(v)) walk(v, key);
      else if (typeof v === "string" || typeof v === "number") out[key] = String(v);
    }
  };
  for (const group of ["color", "gradient", "radius", "shadow"]) {
    walk(tokens?.[group], `--pfz-${group}`);
  }
  if (tokens?.font?.body) out["--pfz-font-body"] = tokens.font.body;
  if (tokens?.font?.heading) out["--pfz-font-heading"] = tokens.font.heading;
  if (tokens?.section?.container) out["--pfz-section-container"] = tokens.section.container;
  if (tokens?.section?.["padding-y"]) out["--pfz-section-padding-y"] = tokens.section["padding-y"];
  if (tokens?.section?.["padding-y-mobile"])
    out["--pfz-section-padding-y-mobile"] = tokens.section["padding-y-mobile"];
  return out;
}

function applyTokens(tokens) {
  const root = document.documentElement;
  for (const [k, v] of Object.entries(toCssVars(tokens))) root.style.setProperty(k, v);

  const family = tokens?.font?.google;
  if (family) {
    const id = "pfz-google-font";
    let link = document.getElementById(id);
    if (!link) {
      link = document.createElement("link");
      link.id = id;
      link.rel = "stylesheet";
      document.head.appendChild(link);
    }
    link.href = `https://fonts.googleapis.com/css2?family=${family.replaceAll(" ", "+")}&display=swap`;
  }
}

export function ThemeProvider({ children }) {
  const [state, setState] = useState({ loading: true, error: null, data: null });

  useEffect(() => {
    let alive = true;
    getHome()
      .then((data) => {
        if (!alive) return;
        applyTokens(data.theme);
        setState({ loading: false, error: null, data });
      })
      .catch((error) => alive && setState({ loading: false, error, data: null }));
    return () => {
      alive = false;
    };
  }, []);

  const value = useMemo(() => {
    const tokens = state.data?.theme ?? {};
    const animation = { ...FALLBACK_ANIM, ...(tokens.animation ?? {}) };
    return {
      ...state,
      tokens,
      animation,
      button: tokens.button ?? { style: "gradient", radius: "pill", hover: "lift" },
    };
  }, [state]);

  return <ThemeCtx.Provider value={value}>{children}</ThemeCtx.Provider>;
}
