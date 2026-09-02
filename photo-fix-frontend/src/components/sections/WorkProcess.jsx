import { Section } from "../ui/Section";
import { SectionHeading } from "../ui/SectionHeading";
import { Reveal } from "../ui/Reveal";
import { Icon } from "../../lib/Icon";

export function WorkProcess({ meta, content }) {
  return (
    <Section id="process" settings={meta.settings}>
      <SectionHeading heading={meta.heading} highlight={meta.highlight_text} sub={meta.sub_heading} />
      <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        {(content ?? []).map((step, i) => (
          <Reveal
            key={step.title}
            index={i}
            className="relative rounded-[var(--pfz-radius-lg)] border border-line bg-canvas p-6 text-center shadow-[var(--pfz-shadow-soft)] transition hover:-translate-y-1"
          >
            <span
              className="absolute -top-3 left-1/2 -translate-x-1/2 rounded-full px-3 py-0.5 text-xs font-bold text-white"
              style={{ backgroundColor: step.accent_color }}
            >
              Step {step.step_no}
            </span>
            <div
              className="mx-auto grid h-14 w-14 place-items-center rounded-full text-white"
              style={{ backgroundColor: step.accent_color }}
            >
              <Icon name={step.icon} size={26} />
            </div>
            <h3 className="mt-4 font-bold text-heading">{step.title}</h3>
            <p className="mt-2 text-sm leading-relaxed text-muted">{step.body}</p>
          </Reveal>
        ))}
      </div>
    </Section>
  );
}
