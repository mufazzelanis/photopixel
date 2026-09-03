import { Section } from "../ui/Section";
import { SectionHeading } from "../ui/SectionHeading";
import { Reveal } from "../ui/Reveal";
import { Button } from "../ui/Button";
import { BeforeAfter } from "../ui/BeforeAfter";
import { Icon } from "../../lib/Icon";
import { prefetchService, hoverPrefetch } from "../../lib/prefetch";

export function Services({ meta, content }) {
  return (
    <Section id="services" settings={meta.settings}>
      <SectionHeading
        heading={meta.heading}
        highlight={meta.highlight_text}
        sub={meta.sub_heading}
      />

      <div className="space-y-16 md:space-y-24">
        {(content ?? []).map((s, i) => {
          const flip = i % 2 === 1;
          return (
            <div
              key={s.slug}
              className={"grid items-center gap-8 lg:grid-cols-2 lg:gap-10 " + (flip ? "" : "")}
            >
              <Reveal className={flip ? "lg:order-2" : ""}>
                <BeforeAfter before={s.before_image} after={s.after_image} />
              </Reveal>
              <Reveal index={1} className={flip ? "lg:order-1" : ""}>
                <h3 className="flex flex-wrap items-center gap-3 text-xl font-extrabold text-heading sm:text-2xl md:text-3xl">
                  <span className="grid h-10 w-10 shrink-0 place-items-center rounded-[var(--pfz-radius-md)] bg-primary/10 text-primary">
                    <Icon name={s.icon} size={22} />
                  </span>
                  {s.title}
                </h3>
                <p className="mt-4 text-base leading-relaxed text-muted sm:text-lg">{s.short_desc}</p>
                <ul className="mt-5 space-y-2.5">
                  {(s.points ?? []).map((p) => (
                    <li key={p} className="flex items-center gap-2 text-base text-body">
                      <span className="grid h-5 w-5 place-items-center rounded-full bg-secondary text-white">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="3" strokeLinecap="round" strokeLinejoin="round"><path d="M20 6L9 17l-5-5" /></svg>
                      </span>
                      {p}
                    </li>
                  ))}
                </ul>
                <Button to={s.btn_url || `/services/${s.slug}`} className="mt-6" {...hoverPrefetch(prefetchService, s.slug)}>
                  {s.btn_label}
                </Button>
              </Reveal>
            </div>
          );
        })}
      </div>
    </Section>
  );
}
