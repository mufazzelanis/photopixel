import { Link } from "react-router-dom";
import { Section } from "../ui/Section";
import { SectionHeading } from "../ui/SectionHeading";
import { Reveal } from "../ui/Reveal";
import { Carousel } from "../ui/Carousel";
import { Button } from "../ui/Button";

export function WorkSamples({ meta, content }) {
  const samples = content ?? [];
  return (
    <Section id="work-samples" settings={meta.settings}>
      <SectionHeading heading={meta.heading} highlight={meta.highlight_text} sub={meta.sub_heading} />
      <Reveal>
        {samples.length ? (
          <Carousel
            slidesPerView={1}
            breakpoints={{ 640: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }}
          >
            {samples.map((s, i) => (
              <div key={i} className="pb-2">
                <Link
                  to={s.category_slug ? `/portfolio/${s.category_slug}` : "/portfolio"}
                  className="group block overflow-hidden rounded-[var(--pfz-radius-lg)] border border-primary/30 shadow-[var(--pfz-shadow-card)] transition duration-300 hover:-translate-y-1 hover:shadow-[var(--pfz-shadow-glow)]"
                >
                  <div className="relative aspect-square overflow-hidden bg-alt">
                    <img
                      src={s.after_image}
                      alt={s.title || "After"}
                      loading="lazy"
                      className="absolute inset-0 h-full w-full object-cover"
                    />
                    {s.before_image ? (
                      <img
                        src={s.before_image}
                        alt={s.title || "Before"}
                        loading="lazy"
                        className="absolute inset-0 h-full w-full object-cover opacity-0 transition-opacity duration-500 group-hover:opacity-100"
                      />
                    ) : null}
                    <span className="absolute inset-0 bg-gradient-to-t from-heading/70 via-transparent to-transparent opacity-0 transition duration-300 group-hover:opacity-100" />
                    <span className="absolute bottom-3 left-3 right-3 flex items-center justify-between gap-2 text-xs font-semibold text-white opacity-0 transition duration-300 group-hover:opacity-100">
                      <span>View Work Samples</span>
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round" className="transition duration-300 group-hover:translate-x-1">
                        <path d="M5 12h14M13 6l6 6-6 6" />
                      </svg>
                    </span>
                  </div>
                </Link>
                {s.title ? <p className="mt-3 text-center text-sm font-medium text-muted">{s.title}</p> : null}
              </div>
            ))}
          </Carousel>
        ) : (
          <p className="text-center text-muted">Samples coming soon.</p>
        )}
      </Reveal>
      <div className="mt-6 text-center">
        <Button to="/portfolio">See More Samples</Button>
      </div>
    </Section>
  );
}
