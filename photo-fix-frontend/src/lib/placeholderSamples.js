/**
 * A category / service page must never look empty — the customer has to see
 * work before they'll ask for a trial. These branded before/after placeholders
 * fill in when the admin hasn't uploaded real samples yet. `ensureSamples()`
 * also pads a short real list up to a minimum so the grid always reads as a
 * proper gallery.
 */

const gradientSvg = (label, from, to) =>
  "data:image/svg+xml;utf8," +
  encodeURIComponent(
    `<svg xmlns='http://www.w3.org/2000/svg' width='900' height='680'>` +
      `<defs><linearGradient id='g' x1='0' y1='0' x2='1' y2='1'>` +
      `<stop offset='0' stop-color='${from}'/><stop offset='1' stop-color='${to}'/>` +
      `</linearGradient></defs>` +
      `<rect width='100%' height='100%' fill='url(#g)'/>` +
      `<text x='50%' y='51%' font-family='Poppins, Arial, sans-serif' font-size='40' font-weight='700' fill='rgba(255,255,255,0.9)' text-anchor='middle'>${label}</text>` +
    `</svg>`,
  );

const BEFORE = gradientSvg("Before", "#eef1f6", "#cbd3e1");

export const PLACEHOLDER_SAMPLES = [
  { title: "Background Removal", before_image: BEFORE, after_image: gradientSvg("After", "#6c4cf1", "#2f6bff") },
  { title: "Color Correction", before_image: BEFORE, after_image: gradientSvg("After", "#ec4899", "#8b5cf6") },
  { title: "Retouching", before_image: BEFORE, after_image: gradientSvg("After", "#0ea5e9", "#6366f1") },
  { title: "Clipping Path", before_image: BEFORE, after_image: gradientSvg("After", "#f59e0b", "#ec4899") },
];

/** Real samples first, padded with placeholders up to `min`. */
export function ensureSamples(list, min = 3) {
  const real = (Array.isArray(list) ? list : []).filter(Boolean);
  if (real.length >= min) return real;
  return [...real, ...PLACEHOLDER_SAMPLES.slice(0, Math.max(0, min - real.length))];
}
