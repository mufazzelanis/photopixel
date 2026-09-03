import { Section } from "../ui/Section";
import { Reveal } from "../ui/Reveal";
import { CmsButton } from "../ui/CmsButton";
import { SmartImage } from "../ui/SmartImage";
import { splitHighlight } from "../../lib/utils";

/**
 * Generic "heading + paragraphs + optional button" beside an illustration.
 * `flip` puts the image on the left. Used for Post-Production and Society blocks.
 */
export function AboutTextMedia({ id, bg, heading, highlight, paragraphs = [], btn, image, flip = false }) {
  const parts = splitHighlight(heading, highlight);

  return (
    <Section id={id} settings={{ bg }}>
      <div className="grid items-center gap-8 lg:grid-cols-2 lg:gap-12">
        <Reveal className={flip ? "lg:order-2" : ""}>
          <h2 className="text-[1.7rem] font-extrabold leading-tight sm:text-[2rem] md:text-[2.55rem]">
            {parts.map((p, i) => (
              <span key={i} className={p.accent ? "pfz-text-gradient" : ""}>{p.text}</span>
            ))}
          </h2>
          <div className="mt-5 space-y-4 text-base leading-relaxed text-muted sm:text-lg">
            {paragraphs.filter(Boolean).map((p, i) => (
              <p key={i}>{p}</p>
            ))}
          </div>
          {btn?.label ? <CmsButton link={btn} className="mt-6" /> : null}
        </Reveal>

        <Reveal
          index={1}
          className={
            "overflow-hidden rounded-[var(--pfz-radius-lg)] shadow-[var(--pfz-shadow-card)] " +
            (flip ? "lg:order-1" : "")
          }
        >
          <SmartImage src={image} alt={heading || ""} className="aspect-[4/3]" />
        </Reveal>
      </div>
    </Section>
  );
}
