import { Section } from "../ui/Section";
import { SectionHeading } from "../ui/SectionHeading";
import { Reveal } from "../ui/Reveal";
import { SmartImage } from "../ui/SmartImage";

export function ClientTypes({ meta, content }) {
  return (
    <Section id="clients" settings={meta.settings}>
      <SectionHeading heading={meta.heading} highlight={meta.highlight_text} sub={meta.sub_heading} />
      <div className="grid gap-6 md:grid-cols-2">
        {(content ?? []).map((c, i) => (
          <Reveal
            key={c.title}
            index={i}
            className="flex gap-5 rounded-[var(--pfz-radius-lg)] bg-canvas p-6 shadow-[var(--pfz-shadow-card)] transition hover:-translate-y-1"
          >
            <SmartImage
              src={c.image}
              alt={c.title}
              wrapperClassName="h-28 w-28 shrink-0 sm:h-32 sm:w-32 rounded-[var(--pfz-radius-md)] bg-alt"
            />
            <div>
              <h3 className="text-lg font-bold text-heading">{c.title}</h3>
              <p className="mt-2 text-base leading-relaxed text-muted">{c.body}</p>
              {c.link?.url ? (
                <a href={c.link.url} className="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-secondary">
                  {c.link.label}
                  <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round"><path d="M5 12h14M13 6l6 6-6 6" /></svg>
                </a>
              ) : null}
            </div>
          </Reveal>
        ))}
      </div>
    </Section>
  );
}
