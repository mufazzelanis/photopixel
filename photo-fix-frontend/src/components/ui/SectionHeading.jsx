import { splitHighlight, cn } from "../../lib/utils";
import { Reveal } from "./Reveal";

/**
 * Eyebrow + heading (with the accent phrase swapped to the gradient text) + intro.
 * Drives every "Our Most Popular <Photo Editing Services>" style block.
 */
export function SectionHeading({
  eyebrow,
  heading,
  highlight,
  sub,
  align = "center",
  invert = false,
  className,
}) {
  const parts = splitHighlight(heading, highlight);
  return (
    <Reveal
      className={cn(
        "mb-8 md:mb-14",
        align === "center" ? "mx-auto max-w-3xl text-center" : "max-w-2xl",
        className,
      )}
    >
      {eyebrow ? (
        <p
          className={cn(
            "mb-3 text-sm font-semibold uppercase tracking-[0.16em] sm:text-[0.95rem]",
            invert ? "text-white/80" : "text-primary",
          )}
        >
          {eyebrow}
        </p>
      ) : null}
      {heading ? (
        <h2
          className={cn(
            "text-[1.75rem] font-extrabold leading-tight sm:text-[2.1rem] md:text-[2.75rem]",
            invert && "text-white",
          )}
        >
          {parts.map((p, i) =>
            p.accent ? (
              <span key={i} className={invert ? "text-white/90 underline decoration-white/40" : "pfz-text-gradient"}>
                {p.text}
              </span>
            ) : (
              <span key={i}>{p.text}</span>
            ),
          )}
        </h2>
      ) : null}
      {sub ? (
        <p
          className={cn(
            "mt-4 text-base leading-relaxed sm:text-lg md:text-xl",
            invert ? "text-white/90" : "text-muted",
          )}
        >
          {sub}
        </p>
      ) : null}
    </Reveal>
  );
}
