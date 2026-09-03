import { Section } from "../ui/Section";
import { Reveal } from "../ui/Reveal";
import { Stars } from "../ui/Stars";
import { SmartImage } from "../ui/SmartImage";
import { useSite } from "../../theme/context";
import { prefersReducedMotion } from "../../lib/utils";

function Card({ t }) {
  return (
    <div className="h-full w-[300px] shrink-0 rounded-[var(--pfz-radius-lg)] bg-white p-6 text-body shadow-[var(--pfz-shadow-card)] sm:w-[360px]">
      <Stars value={t.rating} />
      <p className="mt-3 text-base leading-relaxed text-muted">{t.quote}</p>
      <div className="mt-5 flex items-center gap-3">
        <SmartImage src={t.avatar} alt={t.name} wrapperClassName="h-11 w-11 shrink-0 rounded-full bg-alt" />
        <div className="min-w-0">
          <p className="text-[0.95rem] font-bold text-heading">{t.name}</p>
          <p className="text-sm text-muted">{t.role}</p>
        </div>
      </div>
    </div>
  );
}

export function Testimonials({ meta, content }) {
  const list = content ?? [];
  const { animation } = useSite();
  const motionOn =
    animation.enabled &&
    animation.carousel_autoplay &&
    !(animation.respect_reduced_motion && prefersReducedMotion());

  // Duration scales with how many cards there are, so the scroll speed feels
  // the same however many testimonials are added in the admin.
  const duration = Math.max(list.length * 6, 18);

  return (
    <Section id="testimonials" settings={meta.settings} containerClassName="text-white">
      <div className="grid gap-8 lg:grid-cols-[0.85fr_2fr] lg:gap-10">
        <Reveal>
          {meta.eyebrow ? (
            <p className="text-sm font-semibold uppercase tracking-[0.14em] text-white/70">{meta.eyebrow}</p>
          ) : null}
          <h2 className="mt-2 text-[1.7rem] font-extrabold text-white sm:text-[2rem] md:text-[2.4rem]">{meta.heading}</h2>
          {meta.body ? <p className="mt-4 text-base leading-relaxed text-white/80">{meta.body}</p> : null}
        </Reveal>

        <Reveal index={1}>
          {list.length ? (
            motionOn ? (
              <div className="pfz-marquee-pause-on-hover overflow-hidden [mask-image:linear-gradient(90deg,transparent,black_5%,black_95%,transparent)]">
                <div
                  className="pfz-marquee-track flex w-max gap-6"
                  style={{ "--pfz-marquee-duration": `${duration}s` }}
                >
                  {[...list, ...list].map((t, i) => (
                    <Card key={i} t={t} />
                  ))}
                </div>
              </div>
            ) : (
              <div className="flex flex-wrap gap-6">
                {list.map((t, i) => (
                  <Card key={i} t={t} />
                ))}
              </div>
            )
          ) : (
            <p className="text-white/70">Reviews coming soon.</p>
          )}
        </Reveal>
      </div>
    </Section>
  );
}
