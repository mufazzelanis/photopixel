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
 * The box's aspect-ratio is a fixed constant, not derived from whichever
 * photo happens to load — a portfolio grid mixes portrait dance shots,
 * square product bottles, and landscape apparel flat-lays, and sizing each
 * card to its own source photo made the grid look ragged (one card twice as
 * tall as its neighbor). Every card is the same box; object-fit: cover crops
 * each photo to fill it instead of letterboxing, so the grid reads as one
 * consistent set.
 *
 * When `image` is given, it's shown as a single photo filling the whole box
 * with no divider or BEFORE/AFTER labels added — those samples are already
 * one photo the admin edited into a before/after layout themselves, so
 * stamping our own labels/split on top of it would double up. `before`/
 * `after` are ignored in that case.
 */
export function StaticCompare({ image, before, after, className = "" }) {
  const boxClassName =
    "flex overflow-hidden rounded-[var(--pfz-radius-md)] border-2 border-primary/25 bg-canvas shadow-[var(--pfz-shadow-soft)] " +
    className;

  if (image) {
    return (
      <div className={boxClassName} style={{ aspectRatio: 1 }}>
        <img src={image} alt="Before and after editing" className="h-full w-full object-cover" loading="lazy" />
      </div>
    );
  }

  return (
    <div className={boxClassName} style={{ aspectRatio: 1 }}>
      <div className="relative min-w-0 flex-1 bg-alt">
        <span className="absolute left-2 top-2 z-10 text-[10px] font-bold uppercase tracking-[0.12em] text-secondary sm:text-xs">
          Before
        </span>
        <img
          src={before || PLACEHOLDER_BEFORE}
          alt="Before editing"
          className="h-full w-full object-cover"
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
          className="h-full w-full object-cover"
          loading="lazy"
        />
      </div>
    </div>
  );
}
