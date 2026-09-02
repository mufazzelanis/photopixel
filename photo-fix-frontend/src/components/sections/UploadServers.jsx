import { Section } from "../ui/Section";
import { Reveal } from "../ui/Reveal";
import { Icon } from "../../lib/Icon";
import { splitHighlight } from "../../lib/utils";

export function UploadServers({ meta, content }) {
  const parts = splitHighlight(meta.heading, meta.highlight_text);
  return (
    <Section id="upload" settings={meta.settings} containerClassName="text-center text-white">
      <Reveal>
        <h2 className="mx-auto max-w-3xl text-2xl font-extrabold text-white sm:text-3xl md:text-4xl">
          {parts.map((p, i) => (
            <span key={i} className={p.accent ? "text-secondary" : ""}>{p.text}</span>
          ))}
        </h2>
        {meta.sub_heading ? (
          <p className="mx-auto mt-4 max-w-2xl text-sm text-white/70 md:text-base">{meta.sub_heading}</p>
        ) : null}
      </Reveal>
      <Reveal index={1} className="mt-8 flex flex-wrap justify-center gap-4">
        {(content ?? []).map((u) => (
          <a
            key={u.name}
            href={u.url}
            target="_blank"
            rel="noopener noreferrer"
            className={
              "inline-flex items-center gap-2 rounded-[var(--pfz-radius-pill)] px-6 py-3 text-sm font-semibold transition hover:-translate-y-0.5 " +
              (u.button_style === "outline"
                ? "border-2 border-white/60 text-white hover:bg-white hover:text-ink"
                : "pfz-gradient-brand text-white")
            }
          >
            <Icon name={u.icon} size={18} />
            {u.name}
          </a>
        ))}
      </Reveal>
    </Section>
  );
}
