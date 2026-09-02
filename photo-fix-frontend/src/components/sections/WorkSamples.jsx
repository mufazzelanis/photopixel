import { Section } from "../ui/Section";
import { SectionHeading } from "../ui/SectionHeading";
import { Reveal } from "../ui/Reveal";
import { Carousel } from "../ui/Carousel";
import { BeforeAfter } from "../ui/BeforeAfter";
import { Button } from "../ui/Button";

export function WorkSamples({ meta, content }) {
  const samples = content ?? [];
  return (
    <Section id="work-samples" settings={meta.settings}>
      <SectionHeading heading={meta.heading} highlight={meta.highlight_text} sub={meta.sub_heading} />
      <Reveal>
        {samples.length ? (
          <Carousel
            slidesPerView={1}
            breakpoints={{ 640: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }}
          >
            {samples.map((s, i) => (
              <div key={i} className="pb-10">
                <BeforeAfter before={s.before_image} after={s.after_image} />
                {s.title ? <p className="mt-3 text-center text-sm font-medium text-muted">{s.title}</p> : null}
              </div>
            ))}
          </Carousel>
        ) : (
          <p className="text-center text-muted">Samples coming soon.</p>
        )}
      </Reveal>
      <div className="mt-6 text-center">
        <Button to="/portfolio">See More Samples</Button>
      </div>
    </Section>
  );
}
