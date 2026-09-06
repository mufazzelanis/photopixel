import { BeforeAfter } from "./BeforeAfter";
import { Reveal } from "./Reveal";
import { PLACEHOLDER_SAMPLES } from "../../lib/placeholderSamples";

/** Standalone 3-up before/after grid for pages that have no gallery data at all. */
export function SamplePlaceholderGrid({ count = 3, className = "" }) {
  return (
    <div className={"grid gap-6 sm:grid-cols-2 lg:grid-cols-3 " + className}>
      {PLACEHOLDER_SAMPLES.slice(0, count).map((s, i) => (
        <Reveal key={s.title} index={i} className="transition duration-300 hover:-translate-y-1">
          <BeforeAfter before={s.before_image} after={s.after_image} />
          <p className="mt-2 text-center text-sm text-muted">{s.title}</p>
        </Reveal>
      ))}
    </div>
  );
}
