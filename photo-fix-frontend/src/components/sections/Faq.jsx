import { Link } from "react-router-dom";
import { Section } from "../ui/Section";
import { SectionHeading } from "../ui/SectionHeading";
import { Reveal } from "../ui/Reveal";
import { Accordion } from "../ui/Accordion";

export function Faq({ meta, content }) {
  return (
    <Section id="faq" settings={meta.settings}>
      <SectionHeading heading={meta.heading} highlight={meta.highlight_text} sub={meta.sub_heading} />
      <Reveal className="mb-6 text-center text-sm">
        <span className="text-muted">Have a Different Question in mind? </span>
        <Link to="/contact" className="font-semibold text-primary">Contact Us</Link>
      </Reveal>
      <Reveal index={1}>
        <Accordion items={content ?? []} />
      </Reveal>
    </Section>
  );
}
