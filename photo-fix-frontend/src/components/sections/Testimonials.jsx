import { Section } from "../ui/Section";
import { Reveal } from "../ui/Reveal";
import { Carousel } from "../ui/Carousel";
import { Stars } from "../ui/Stars";
import { SmartImage } from "../ui/SmartImage";

export function Testimonials({ meta, content }) {
  const list = content ?? [];
  return (
    <Section id="testimonials" settings={meta.settings} containerClassName="text-white">
      <div className="grid gap-8 lg:grid-cols-[0.85fr_2fr] lg:gap-10">
        <Reveal>
          {meta.eyebrow ? (
            <p className="text-sm font-semibold uppercase tracking-[0.14em] text-white/70">{meta.eyebrow}</p>
          ) : null}
          <h2 className="mt-2 text-2xl font-extrabold text-white sm:text-3xl md:text-4xl">{meta.heading}</h2>
          {meta.body ? <p className="mt-4 text-sm leading-relaxed text-white/80">{meta.body}</p> : null}
        </Reveal>

        <Reveal index={1}>
          <Carousel slidesPerView={1} breakpoints={{ 768: { slidesPerView: 2 } }}>
            {list.map((t, i) => (
              <div key={i} className="h-full rounded-[var(--pfz-radius-lg)] bg-white p-6 text-body shadow-[var(--pfz-shadow-card)]">
                <Stars value={t.rating} />
                <p className="mt-3 text-sm leading-relaxed text-muted">{t.quote}</p>
                <div className="mt-5 flex items-center gap-3">
                  <SmartImage src={t.avatar} alt={t.name} wrapperClassName="h-11 w-11 rounded-full bg-alt" />
                  <div>
                    <p className="text-sm font-bold text-heading">{t.name}</p>
                    <p className="text-xs text-muted">{t.role}</p>
                  </div>
                </div>
              </div>
            ))}
          </Carousel>
        </Reveal>
      </div>
    </Section>
  );
}
