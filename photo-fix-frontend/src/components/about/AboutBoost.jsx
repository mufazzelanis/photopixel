import { Section } from "../ui/Section";
import { SectionHeading } from "../ui/SectionHeading";
import { Reveal } from "../ui/Reveal";
import { Icon } from "../../lib/Icon";

export function AboutBoost({ data }) {
  return (
    <Section id="about-boost" settings={{ bg: "base" }}>
      <SectionHeading heading={data.heading} highlight={data.highlight} sub={data.sub_text} />

      <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        {(data.features ?? []).map((f, i) => (
          <Reveal
            key={f.title}
            index={i}
            className="group rounded-[var(--pfz-radius-lg)] bg-canvas p-6 shadow-[var(--pfz-shadow-soft)] transition hover:-translate-y-1 hover:shadow-[var(--pfz-shadow-card)]"
          >
            <span
              className="grid h-12 w-12 place-items-center rounded-[var(--pfz-radius-md)] text-white"
              style={{ backgroundColor: f.header_color }}
            >
              <Icon name={f.icon} size={24} />
            </span>
            <h3
              className="mt-4 inline-block rounded-[var(--pfz-radius-sm)] px-3 py-1.5 text-sm font-bold text-white"
              style={{ backgroundColor: f.header_color }}
            >
              {f.title}
            </h3>
            <p className="mt-3 text-base leading-relaxed text-muted">{f.body}</p>
          </Reveal>
        ))}
      </div>
    </Section>
  );
}
