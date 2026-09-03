import { Section } from "../ui/Section";
import { Reveal } from "../ui/Reveal";
import { CmsButton } from "../ui/CmsButton";
import { SmartImage } from "../ui/SmartImage";
import { splitHighlight } from "../../lib/utils";

function youtubeId(url = "") {
  const m = url.match(/(?:youtu\.be\/|v=|embed\/)([\w-]{11})/);
  return m?.[1];
}

export function About({ meta, content }) {
  const a = content;
  const parts = splitHighlight(a.heading, a.highlight_text);
  const vid = youtubeId(a.video_url);

  return (
    <Section id="about" settings={meta.settings}>
      <div className="grid items-center gap-8 lg:grid-cols-2 lg:gap-12">
        <Reveal className="overflow-hidden rounded-[var(--pfz-radius-lg)] shadow-[var(--pfz-shadow-card)]">
          {vid ? (
            <div className="aspect-video">
              <iframe
                className="h-full w-full"
                src={`https://www.youtube.com/embed/${vid}`}
                title={a.heading || "Intro video"}
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowFullScreen
              />
            </div>
          ) : (
            <SmartImage src={a.thumbnail} alt={a.heading || ""} className="aspect-video" />
          )}
        </Reveal>

        <Reveal index={1}>
          <h2 className="text-[1.7rem] font-extrabold leading-tight sm:text-[2rem] md:text-[2.55rem]">
            {parts.map((p, i) => (
              <span key={i} className={p.accent ? "pfz-text-gradient" : ""}>{p.text}</span>
            ))}
          </h2>
          <div className="mt-5 space-y-4 text-muted leading-relaxed">
            {a.body_1 ? <p>{a.body_1}</p> : null}
            {a.body_2 ? <p>{a.body_2}</p> : null}
          </div>
          <CmsButton link={a.btn} className="mt-6" />
        </Reveal>
      </div>
    </Section>
  );
}
