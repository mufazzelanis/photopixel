import { Section } from "../ui/Section";
import { Reveal } from "../ui/Reveal";
import { Icon } from "../../lib/Icon";
import { SmartImage } from "../ui/SmartImage";
import { splitHighlight } from "../../lib/utils";

export function WhyChoose({ meta, content }) {
  const w = content ?? {};
  const parts = splitHighlight(w.heading || meta.heading, w.highlight_text || meta.highlight_text);

  return (
    <Section id="why" settings={meta.settings}>
      <div className="grid items-center gap-8 lg:grid-cols-2 lg:gap-12">
        <Reveal>
          <h2 className="text-[1.7rem] font-extrabold leading-tight sm:text-[2rem] md:text-[2.55rem]">
            {parts.map((p, i) => (
              <span key={i} className={p.accent ? "pfz-text-gradient" : ""}>{p.text}</span>
            ))}
          </h2>
          <div className="mt-5 space-y-4 text-muted leading-relaxed">
            {w.body_1 ? <p>{w.body_1}</p> : null}
            {w.body_2 ? <p>{w.body_2}</p> : null}
          </div>
          <ol className="mt-6 space-y-2.5">
            {(w.points ?? []).map((p, i) => (
              <li key={p} className="flex gap-3 text-sm text-body">
                <span className="grid h-6 w-6 shrink-0 place-items-center rounded-full bg-primary/10 text-xs font-bold text-primary">
                  {i + 1}
                </span>
                {p}
              </li>
            ))}
          </ol>
          {w.features?.length ? (
            <div className="mt-8 flex flex-wrap gap-6">
              {w.features.map((f) => (
                <div key={f.title} className="flex items-center gap-2">
                  <span className="grid h-9 w-9 place-items-center rounded-[var(--pfz-radius-sm)] bg-primary/10 text-primary">
                    <Icon name={f.icon} size={18} />
                  </span>
                  <span className="text-sm font-semibold text-heading">{f.title}</span>
                </div>
              ))}
            </div>
          ) : null}
        </Reveal>

        <Reveal index={1} className="overflow-hidden rounded-[var(--pfz-radius-lg)] shadow-[var(--pfz-shadow-card)]">
          <SmartImage src={w.image} alt={w.heading || ""} className="aspect-square" />
        </Reveal>
      </div>
    </Section>
  );
}
