import { Link } from "react-router-dom";
import { Section } from "../ui/Section";
import { SectionHeading } from "../ui/SectionHeading";
import { Reveal } from "../ui/Reveal";
import { Button } from "../ui/Button";
import { SmartImage } from "../ui/SmartImage";
import { formatTime } from "../../lib/utils";

export function BlogTeaser({ meta, content }) {
  const posts = content ?? [];
  return (
    <Section id="blog" settings={meta.settings}>
      <SectionHeading heading={meta.heading} highlight={meta.highlight_text} sub={meta.sub_heading} />
      <div className="grid gap-6 md:grid-cols-3">
        {posts.map((p, i) => (
          <Reveal
            key={p.slug}
            index={i}
            as="article"
            className="overflow-hidden rounded-[var(--pfz-radius-lg)] bg-canvas shadow-[var(--pfz-shadow-card)] transition hover:-translate-y-1"
          >
            <Link to={`/blog/${p.slug}`}>
              <SmartImage src={p.cover} alt={p.title} wrapperClassName="aspect-[16/10] bg-alt" />
            </Link>
            <div className="p-5">
              <h3 className="text-base font-bold leading-snug text-heading">
                <Link to={`/blog/${p.slug}`}>{p.title}</Link>
              </h3>
              <p className="mt-1 text-xs text-muted">{formatTime(p.published_at)}</p>
              <Link to={`/blog/${p.slug}`} className="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-primary">
                Read More
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round"><path d="M5 12h14M13 6l6 6-6 6" /></svg>
              </Link>
            </div>
          </Reveal>
        ))}
      </div>
      <div className="mt-8 text-center">
        <Button to="/blog">View all articles</Button>
      </div>
    </Section>
  );
}
