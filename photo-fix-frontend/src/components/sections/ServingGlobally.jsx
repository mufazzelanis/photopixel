import { Section } from "../ui/Section";
import { Reveal } from "../ui/Reveal";
import { parseLinkString } from "../../lib/utils";

const FLAG_EMOJI = { ca: "🇨🇦", de: "🇩🇪", gb: "🇬🇧", au: "🇦🇺", it: "🇮🇹", us: "🇺🇸", fr: "🇫🇷" };

export function ServingGlobally({ meta, content }) {
  const link = parseLinkString(meta.sub_heading);

  return (
    <Section id="serving" settings={meta.settings}>
      <Reveal className="flex flex-col items-center justify-between gap-8 md:flex-row">
        <div>
          <h2 className="text-2xl font-extrabold text-primary md:text-3xl">{meta.heading}</h2>
          {link ? (
            <a href={link.url} className="mt-2 inline-flex items-center gap-1 text-sm font-semibold text-secondary">
              {link.label}
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round"><path d="M5 12h14M13 6l6 6-6 6" /></svg>
            </a>
          ) : null}
        </div>
        <div className="flex flex-wrap items-center gap-5">
          {(content ?? []).map((c, i) => (
            <Reveal key={c.name} index={i} className="flex flex-col items-center gap-1">
              {c.flag ? (
                <img src={c.flag} alt={c.name} className="h-9 w-14 rounded object-cover shadow-sm" />
              ) : (
                <span className="text-4xl">{FLAG_EMOJI[c.code] ?? "🏳️"}</span>
              )}
            </Reveal>
          ))}
        </div>
      </Reveal>
    </Section>
  );
}
