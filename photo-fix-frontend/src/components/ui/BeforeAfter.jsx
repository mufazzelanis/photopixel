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

export function BeforeAfter({ before, after, className = "" }) {
  return (
    <div
      className={
        "overflow-hidden rounded-[var(--pfz-radius-lg)] border border-primary/30 shadow-[var(--pfz-shadow-card)] " +
        className
      }
    >
      <ReactCompareSlider
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
          />
        }
      />
    </div>
  );
}
