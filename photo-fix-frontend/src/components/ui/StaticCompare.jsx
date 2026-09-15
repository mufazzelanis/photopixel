import { useState } from "react";

const PLACEHOLDER_BEFORE =
  "data:image/svg+xml;utf8," +
  encodeURIComponent(
    `<svg xmlns='http://www.w3.org/2000/svg' width='800' height='800'><rect width='100%' height='100%' fill='%23e9ecf5'/></svg>`,
  );
const PLACEHOLDER_AFTER =
  "data:image/svg+xml;utf8," +
  encodeURIComponent(
    `<svg xmlns='http://www.w3.org/2000/svg' width='800' height='800'><rect width='100%' height='100%' fill='%23ffffff'/><rect width='100%' height='100%' fill='url(%23g)'/><defs><pattern id='g' width='24' height='24' patternUnits='userSpaceOnUse'><rect width='12' height='12' fill='%23f0f0f0'/><rect x='12' y='12' width='12' height='12' fill='%23f0f0f0'/></pattern></defs></svg>`,
  );

/**
 * Plain side-by-side before/after — two static images in one bordered box
 * with small BEFORE/AFTER corner labels and a colored divider, no drag/hover
 * interaction. Matches the reference portfolio design exactly (as opposed to
 * `BeforeAfter`, the interactive slider used elsewhere on the site).
 *
 * The box's aspect-ratio is taken from the real "after" photo the moment it
 * loads and both images render with object-fit: contain, so — same as
 * `BeforeAfter` — whatever size an admin uploads shows completely, never
 * cropped. Since the box holds the image TWICE side by side (before + after,
 * sharing the same height), its ratio is double a single photo's own ratio —
 * get this wrong and each half ends up letterboxed with dead space top and
 * bottom, which is exactly what happens if you naively use the photo's own
 * w/h ratio for the whole box.
 */
export function StaticCompare({ before, after, className = "" }) {
  const [ratio, setRatio] = useState((4 / 3) * 2);

  return (
    <div
      className={
        "flex overflow-hidden rounded-[var(--pfz-radius-md)] border-2 border-primary/25 bg-canvas shadow-[var(--pfz-shadow-soft)] " +
        className
      }
      style={{ aspectRatio: ratio }}
    >
      <div className="relative min-w-0 flex-1 bg-alt">
        <span className="absolute left-2 top-2 z-10 text-[10px] font-bold uppercase tracking-[0.12em] text-secondary sm:text-xs">
          Before
        </span>
        <img
          src={before || PLACEHOLDER_BEFORE}
          alt="Before editing"
          className="h-full w-full object-contain"
          loading="lazy"
        />
      </div>

      <div className="pfz-gradient-brand w-[3px] shrink-0" />

      <div className="relative min-w-0 flex-1 bg-alt">
        <span className="absolute right-2 top-2 z-10 text-[10px] font-bold uppercase tracking-[0.12em] text-accent sm:text-xs">
          After
        </span>
        <img
          src={after || PLACEHOLDER_AFTER}
          alt="After editing"
          className="h-full w-full object-contain"
          loading="lazy"
          onLoad={(e) => {
            const { naturalWidth: w, naturalHeight: h } = e.currentTarget;
            if (w && h) setRatio((w / h) * 2);
          }}
        />
      </div>
    </div>
  );
}
