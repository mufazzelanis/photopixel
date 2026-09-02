/** Tiny classnames helper. */
export function cn(...parts) {
  return parts.flat().filter(Boolean).join(" ");
}

/**
 * Renders a heading with one phrase swapped for the accent-coloured span.
 * Returns an array of React-safe strings/objects via a marker the caller maps.
 */
export function splitHighlight(text, highlight) {
  if (!text) return [{ text: "", accent: false }];
  if (!highlight || !text.includes(highlight)) return [{ text, accent: false }];
  const [before, after] = text.split(highlight);
  return [
    { text: before, accent: false },
    { text: highlight, accent: true },
    { text: after, accent: false },
  ];
}

/** "Label|/url" convention used by some section sub-headings. */
export function parseLinkString(value) {
  if (!value || !value.includes("|")) return null;
  const [label, url] = value.split("|");
  return { label: label.trim(), url: url.trim() };
}

export function formatDate(iso) {
  if (!iso) return "";
  try {
    return new Date(iso).toLocaleDateString("en-US", {
      month: "short",
      day: "numeric",
      year: "numeric",
    });
  } catch {
    return "";
  }
}

export function formatTime(iso) {
  if (!iso) return "";
  try {
    return new Date(iso).toLocaleTimeString("en-US", {
      hour: "numeric",
      minute: "2-digit",
    });
  } catch {
    return "";
  }
}

export const prefersReducedMotion = () =>
  typeof window !== "undefined" &&
  window.matchMedia?.("(prefers-reduced-motion: reduce)").matches;
