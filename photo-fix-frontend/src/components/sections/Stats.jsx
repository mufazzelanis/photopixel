import { Section } from "../ui/Section";
import { SectionHeading } from "../ui/SectionHeading";
import { Reveal } from "../ui/Reveal";
import { Counter } from "../ui/Counter";
import { Icon } from "../../lib/Icon";

export function Stats({ meta, content }) {
  return (
    <Section id="stats" settings={meta.settings}>
      <SectionHeading heading={meta.heading} highlight={meta.highlight_text} sub={meta.sub_heading} />
      <div className="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        {(content ?? []).map((s, i) => (
          <Reveal
            key={s.label}
            index={i}
            className="rounded-[var(--pfz-radius-lg)] bg-secondary/10 p-6 text-center"
          >
            <span className="mx-auto grid h-12 w-12 place-items-center rounded-[var(--pfz-radius-md)] bg-canvas text-primary shadow-[var(--pfz-shadow-soft)]">
              <Icon name={s.icon} size={24} />
            </span>
            <p className="mt-4 text-[1.9rem] font-extrabold text-heading sm:text-4xl md:text-5xl">
              <Counter value={s.value} prefix={s.prefix ?? ""} suffix={s.suffix ?? ""} />
            </p>
            <p className="mt-1 text-sm text-muted">{s.label}</p>
          </Reveal>
        ))}
      </div>
    </Section>
  );
}
