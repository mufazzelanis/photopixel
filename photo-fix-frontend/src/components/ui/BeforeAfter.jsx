import { useState } from "react";
import {
  ReactCompareSlider,
  ReactCompareSliderImage,
} from "react-compare-slider";

const PLACEHOLDER_BEFORE =
  "data:image/svg+xml;utf8," +
  encodeURIComponent(
    `<svg xmlns='http://www.w3.org/2000/svg' width='800' height='800'><rect width='100%' height='100%' fill='%23e9ecf5'/><text x='50%' y='50%' font-family='sans-serif' font-size='34' fill='%237a8199' text-anchor='middle'>BEFORE</text></svg>`,
  );
const PLACEHOLDER_AFTER =
  "data:image/svg+xml;utf8," +
  encodeURIComponent(
    `<svg xmlns='http://www.w3.org/2000/svg' width='800' height='800'><rect width='100%' height='100%' fill='%23ffffff'/><rect width='100%' height='100%' fill='url(%23g)'/><defs><pattern id='g' width='24' height='24' patternUnits='userSpaceOnUse'><rect width='12' height='12' fill='%23f0f0f0'/><rect x='12' y='12' width='12' height='12' fill='%23f0f0f0'/></pattern></defs><text x='50%' y='50%' font-family='sans-serif' font-size='34' fill='%237a8199' text-anchor='middle'>AFTER</text></svg>`,
  );

export function BeforeAfter({ before, after, className = "", hoverToReveal = false }) {
  // react-compare-slider has no height logic of its own — every layer is
  // `height: 100%`, all the way down to the images, so it only ever renders
  // at a real size when SOMETHING in the surrounding layout happens to
  // already have a height (e.g. a CSS grid row stretched by a taller
  // sibling). Drop it into any other layout and it silently collapses to
  // ~0px. Fixing that here, once, for every page that uses this component:
  // give the wrapper an explicit aspect-ratio, taken from the real "after"
  // photo the moment it loads (default 1:1 — matches the placeholder square
  // — until then). Because the box then always matches the photo's own
  // proportions, "cover" never has anything to crop — any size the admin
  // uploads fits perfectly, full image always visible.
  const [ratio, setRatio] = useState(1);

  return (
    <div
      className={
        "overflow-hidden rounded-[var(--pfz-radius-lg)] border border-primary/30 shadow-[var(--pfz-shadow-card)] " +
        className
      }
      style={{ aspectRatio: ratio }}
    >
      <ReactCompareSlider
        // The library's own root only ever sets `max-height: 100%` — that
        // caps a height, it doesn't establish one, so without this explicit
        // `height: 100%` it still collapses to 0 even inside a box that
        // itself has a perfectly real (aspect-ratio-derived) height.
        style={{ height: "100%", width: "100%" }}
        // When set, moving the mouse across the image scrubs the position —
        // no click/drag needed. Dragging the handle still works too; this
        // only adds the hover behavior on top of it.
        changePositionOnHover={hoverToReveal}
        itemOne={
          <ReactCompareSliderImage
            src={before || PLACEHOLDER_BEFORE}
            alt="Before editing"
          />
        }
        itemTwo={
          <ReactCompareSliderImage
            src={after || PLACEHOLDER_AFTER}
            alt="After editing"
            onLoad={(e) => {
              const { naturalWidth: w, naturalHeight: h } = e.currentTarget;
              if (w && h) setRatio(w / h);
            }}
          />
        }
      />
    </div>
  );
}
