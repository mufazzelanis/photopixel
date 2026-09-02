/**
 * Lightweight stroke-icon set keyed by the string stored in the admin panel
 * (value_card.icon, service.icon, process_step.icon, social_link.icon, ...).
 * Unknown keys fall back to a neutral spark so nothing ever breaks.
 */
const P = {
  chart: "M3 3v18h18 M7 15l3-3 3 2 5-6",
  truck: "M3 7h11v9H3z M14 10h4l3 3v3h-7 M7 19a2 2 0 1 0 .01 0 M17 19a2 2 0 1 0 .01 0",
  wallet: "M3 7h16a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h12 M17 13h.01",
  headset: "M4 13v-2a8 8 0 0 1 16 0v2 M4 13a2 2 0 0 0 2 2h1v-5H6a2 2 0 0 0-2 2z M20 13a2 2 0 0 1-2 2h-1v-5h1a2 2 0 0 1 2 2z M18 15v1a4 4 0 0 1-4 4h-2",
  scissors: "M6 6a2 2 0 1 0 .01 0 M6 18a2 2 0 1 0 .01 0 M8.5 8.5L20 20 M8.5 15.5L20 4 M8.5 8.5 15 12",
  sparkles: "M12 3l1.9 4.6L18.5 9.5 13.9 11.4 12 16l-1.9-4.6L5.5 9.5l4.6-1.9z M18 15l.8 2 2 .8-2 .8-.8 2-.8-2-2-.8 2-.8z",
  layers: "M12 3l9 5-9 5-9-5z M3 13l9 5 9-5 M3 18l9 5 9-5",
  shirt: "M8 3l4 3 4-3 4 3-2 4-2-1v11H8V9L6 10 4 6z",
  contrast: "M12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18z M12 3v18",
  palette: "M12 3a9 9 0 1 0 0 18c1.5 0 2-1 2-2s-.5-2-2-2h-1a2 2 0 0 1 0-4h3a5 5 0 0 0 0-8 9 9 0 0 0-2 0z M7 10h.01 M10 7h.01 M15 8h.01",
  eraser: "M4 20h16 M14 6l4 4-8 8H6l-2-2 8-8z",
  upload: "M12 15V4 M8 8l4-4 4 4 M4 15v3a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-3",
  gift: "M4 12h16v8H4z M12 12v8 M4 8h16v4H4z M12 8S9 3 6.5 5.5 12 8 12 8z M12 8s3-5 5.5-2.5S12 8 12 8z",
  monitor: "M3 4h18v12H3z M9 20h6 M12 16v4",
  "file-check": "M6 3h8l4 4v14H6z M14 3v4h4 M9 14l2 2 4-4",
  "credit-card": "M3 6h18v12H3z M3 10h18 M7 15h4",
  bolt: "M13 2L4 14h7l-1 8 9-12h-7z",
  "badge-check": "M12 3l2.3 1.7 2.8-.3 1 2.7 2.5 1.4-1 2.7 1 2.7-2.5 1.4-1 2.7-2.8-.3L12 21l-2.3-1.7-2.8.3-1-2.7L3.4 15l1-2.7-1-2.7 2.5-1.4 1-2.7 2.8.3z M9 12l2 2 4-4",
  "folder-check": "M3 6h6l2 2h10v11H3z M9 13l2 2 4-4",
  users: "M9 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6z M3 20a6 6 0 0 1 12 0 M16 6a3 3 0 0 1 0 6 M21 20a6 6 0 0 0-4-5.7",
  globe: "M12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18z M3 12h18 M12 3c2.5 2.5 4 5.6 4 9s-1.5 6.5-4 9c-2.5-2.5-4-5.6-4-9s1.5-6.5 4-9z",
  heart: "M12 21s-7-4.5-9.5-9C1 8.5 3 5 6.5 5 9 5 12 8 12 8s3-3 5.5-3C21 5 23 8.5 21.5 12 19 16.5 12 21 12 21z",
  handshake: "M8 11l3-3 4 4 3-3 3 3-6 6-3-3-4 3-3-3z M2 12l4 4 M22 12l-4 4",
  facebook: "M14 8h3V4h-3a4 4 0 0 0-4 4v3H7v4h3v7h4v-7h3l1-4h-4V8a1 1 0 0 1 1-1z",
  linkedin: "M6 9v11 M6 5.5a1.5 1.5 0 1 0 .01 0 M11 20v-6a3 3 0 0 1 6 0v6 M11 11v9",
  x: "M4 4l16 16 M20 4L4 20",
  instagram: "M4 8a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v8a4 4 0 0 1-4 4H8a4 4 0 0 1-4-4z M12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6z M17 7h.01",
  youtube: "M3 8a3 3 0 0 1 3-3h12a3 3 0 0 1 3 3v8a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3z M10 9l5 3-5 3z",
  star: "M12 3l2.9 5.9 6.5.9-4.7 4.6 1.1 6.5L12 18l-5.8 3 1.1-6.5L2.6 9.8l6.5-.9z",
  wetransfer: "M4 7l3 10 3-8 3 8 3-10 M20 7l-1 10",
  dropbox: "M6 3l6 4-6 4-6-4z M18 3l6 4-6 4-6-4z M6 15l6-4 6 4-6 4z M9 18l3 2 3-2",
  camera: "M4 8h3l2-3h6l2 3h3a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z M12 17a4 4 0 1 0 0-8 4 4 0 0 0 0 8z",
  car: "M3 13l1.5-4.5A2 2 0 0 1 6.4 7h11.2a2 2 0 0 1 1.9 1.5L21 13 M3 13h18v4a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1v-1H6v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z M7 17a2 2 0 1 0 .01 0 M17 17a2 2 0 1 0 .01 0",
  history: "M12 8v4l3 2 M12 3a9 9 0 1 0 8.94 10 M21 3v5h-5",
  calendar: "M4 5h16v15H4z M4 9h16 M8 3v4 M16 3v4",
  gem: "M2 9h20 M9 3l-3 6 6 12 6-12-3-6z M6 3h12l4 6-10 12L2 9z",
  shoe: "M3 17c0-3 2-4 4-5l4-4 3 1-1 3 6 1a2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z M3 17v3h18v-3",
  sofa: "M5 12V8a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v4 M3 12h18v6a1 1 0 0 1-1 1h-1v2h-2v-2H7v2H5v-2H4a1 1 0 0 1-1-1z",
  baby: "M12 21c-4 0-7-3-7-7a7 7 0 0 1 14 0c0 4-3 7-7 7z M9 11h.01 M15 11h.01 M9.5 15a3 3 0 0 0 5 0",
};

export function Icon({ name, className = "", size = 24, strokeWidth = 1.8, ...rest }) {
  const d = P[name] ?? P.sparkles;
  return (
    <svg
      viewBox="0 0 24 24"
      width={size}
      height={size}
      fill="none"
      stroke="currentColor"
      strokeWidth={strokeWidth}
      strokeLinecap="round"
      strokeLinejoin="round"
      className={className}
      aria-hidden="true"
      {...rest}
    >
      {d.split(" M").map((seg, i) => (
        <path key={i} d={(i === 0 ? seg : "M" + seg)} />
      ))}
    </svg>
  );
}
