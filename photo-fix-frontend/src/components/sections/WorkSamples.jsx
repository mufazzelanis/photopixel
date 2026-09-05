import { Link } from "react-router-dom";
import { Section } from "../ui/Section";
import { SectionHeading } from "../ui/SectionHeading";
import { Reveal } from "../ui/Reveal";
import { Button } from "../ui/Button";
import { SmartImage } from "../ui/SmartImage";
import { Icon } from "../../lib/Icon";

/** Homepage "Satisfied Clients" spotlight — the admin's chosen most-popular
 *  categories. "See More Samples" always opens the full /portfolio page. */
export function WorkSamples({ meta, content }) {
  const categories = content ?? [];
  return (
    <Section id="work-samples" settings={meta.settings}>
      <SectionHeading heading={meta.heading} highlight={meta.highlight_text} sub={meta.sub_heading} />
      {categories.length ? (
        <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
          {categories.map((cat, i) => (
            <Reveal
              key={cat.slug}
              index={i}
              as="article"
              className="group overflow-hidden rounded-[var(--pfz-radius-lg)] border border-primary/30 bg-canvas shadow-[var(--pfz-shadow-card)] transition duration-300 hover:-translate-y-1.5 hover:shadow-[var(--pfz-shadow-glow)]"
            >
              <Link to={`/portfolio/${cat.slug}`} className="block">
                <div className="relative aspect-[4/3] overflow-hidden bg-alt">
                  {cat.cover ? (
                    <SmartImage
                      src={cat.cover}
                      alt={cat.name}
                      loading="lazy"
                      wrapperClassName="absolute inset-0 h-full w-full"
                      className="object-center transition duration-500 group-hover:scale-110"
                    />
                  ) : (
                    <div className="grid h-full w-full place-items-center text-primary/40">
                      <Icon name={cat.icon || "layers"} size={40} />
                    </div>
                  )}
                  <div className="absolute inset-0 bg-gradient-to-t from-heading/70 via-transparent to-transparent opacity-0 transition duration-300 group-hover:opacity-100" />
                  <span className="absolute bottom-3 left-3 right-3 flex items-center justify-between gap-2 text-xs font-semibold text-white opacity-0 transition duration-300 group-hover:opacity-100">
                    <span>View Work Samples</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round" className="transition duration-300 group-hover:translate-x-1">
                      <path d="M5 12h14M13 6l6 6-6 6" />
                    </svg>
                  </span>
                </div>
                <p className="mt-3 pb-4 text-center text-sm font-medium text-muted">{cat.name}</p>
              </Link>
            </Reveal>
          ))}
        </div>
      ) : (
        <p className="text-center text-muted">Samples coming soon.</p>
      )}
      <div className="mt-8 text-center">
        <Button to="/portfolio">See More Samples</Button>
      </div>
    </Section>
  );
}
