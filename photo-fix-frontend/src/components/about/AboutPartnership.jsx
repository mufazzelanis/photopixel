import { Section } from "../ui/Section";
import { SectionHeading } from "../ui/SectionHeading";
import { Reveal } from "../ui/Reveal";
import { Icon } from "../../lib/Icon";
import { SmartImage } from "../ui/SmartImage";

function youtubeId(url = "") {
  const m = url.match(/(?:youtu\.be\/|v=|embed\/)([\w-]{11})/);
  return m?.[1];
}

export function AboutPartnership({ data }) {
  const vid = youtubeId(data.video_url);

  return (
    <Section id="about-partnership" settings={{ bg: "bg-soft" }}>
      <SectionHeading heading={data.heading} highlight={data.highlight} sub={data.sub_text} />

      <div className="grid items-center gap-8 lg:grid-cols-2 lg:gap-12">
        <Reveal className="overflow-hidden rounded-[var(--pfz-radius-lg)] shadow-[var(--pfz-shadow-card)]">
          {vid ? (
            <div className="aspect-video">
              <iframe
                className="h-full w-full"
                src={`https://www.youtube.com/embed/${vid}`}
                title={data.heading || "Why partner with us"}
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowFullScreen
              />
            </div>
          ) : (
            <SmartImage src="" alt="" className="aspect-video" />
          )}
        </Reveal>

        <Reveal index={1}>
          <ul className="space-y-4">
            {(data.points ?? []).map((p) => (
              <li key={p.text} className="flex items-center gap-4">
                <span className="grid h-11 w-11 shrink-0 place-items-center rounded-[var(--pfz-radius-md)] bg-primary/10 text-primary">
                  <Icon name={p.icon} size={22} />
                </span>
                <span className="text-base font-semibold text-heading sm:text-lg">{p.text}</span>
              </li>
            ))}
          </ul>
        </Reveal>
      </div>
    </Section>
  );
}
