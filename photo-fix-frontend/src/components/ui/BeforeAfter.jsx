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

export function BeforeAfter({ before, after, className = "", hoverToReveal = false, frameless = false }) {
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
  //
  // Deliberately no "stretch to fill a taller sibling / cover-crop" option
  // here — that was tried for the Pricing cards and looked broken for any
  // service with no real photo yet (the placeholder's centered text gets
  // cropped clean off when force-covered into an extreme aspect ratio,
  // leaving what looks like a flat, content-less color block). Callers that
  // want equal-height columns should pin buttons to the bottom with
  // mt-auto on a flex column instead of stretching the photo itself.
  // `frameless` drops the card-within-a-card look (own border/shadow/rounded
  // corners on all four sides) for layouts — like the Pricing cards — where
  // the photo is meant to sit flush edge-to-edge against an outer container
  // that already has its own border. The outer container's own
  // `overflow-hidden` + rounding then clips the shared corner, instead of
  // this component rounding its own — sizing logic (the aspect-ratio lock
  // that prevents the zero-height collapse bug) stays identical either way.
  const [ratio, setRatio] = useState(1);

  return (
    <div
      className={
        (frameless ? "overflow-hidden " : "overflow-hidden rounded-[var(--pfz-radius-lg)] border border-primary/30 shadow-[var(--pfz-shadow-card)] ") +
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
