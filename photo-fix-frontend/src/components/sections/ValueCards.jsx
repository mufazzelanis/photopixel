import { Section } from "../ui/Section";
import { Reveal } from "../ui/Reveal";
import { Icon } from "../../lib/Icon";
import { Button } from "../ui/Button";
import { parseLinkString, splitHighlight } from "../../lib/utils";

export function ValueCards({ meta, content }) {
  const parts = splitHighlight(meta.heading, meta.highlight_text);
  const cta = parseLinkString(meta.sub_heading);
  const paras = (meta.body ?? "").split("\n\n").filter(Boolean);

  return (
    <Section id="value" settings={meta.settings}>
      <div className="grid items-center gap-8 lg:grid-cols-2 lg:gap-12">
        <Reveal>
          <h2 className="text-2xl font-extrabold leading-tight sm:text-3xl md:text-[2.4rem]">
            {parts.map((p, i) => (
              <span key={i} className={p.accent ? "pfz-text-gradient" : ""}>{p.text}</span>
            ))}
          </h2>
          <div className="mt-5 space-y-4 text-muted leading-relaxed">
            {paras.map((p, i) => <p key={i}>{p}</p>)}
          </div>
          {cta ? (
            <Button href={cta.url} className="mt-6">{cta.label}</Button>
          ) : null}
        </Reveal>

        <div className="grid gap-5 sm:grid-cols-2">
          {(content ?? []).map((card, i) => (
            <Reveal
              key={card.title}
              index={i}
              className={
                "overflow-hidden rounded-[var(--pfz-radius-lg)] bg-canvas shadow-[var(--pfz-shadow-card)] transition hover:-translate-y-1 " +
                (i % 2 ? "sm:mt-8" : "")
              }
            >
              <div
                className="flex items-center justify-center py-6 text-white"
                style={{ backgroundColor: card.header_color }}
              >
                <Icon name={card.icon} size={30} />
              </div>
              <div className="p-6 text-center">
                <h3 className="text-lg font-bold text-heading">{card.title}</h3>
                <p className="mt-2 text-sm leading-relaxed text-muted">{card.body}</p>
              </div>
            </Reveal>
          ))}
        </div>
      </div>
    </Section>
  );
}
