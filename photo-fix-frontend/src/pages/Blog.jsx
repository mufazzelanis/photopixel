import { useState } from "react";
import { Link } from "react-router-dom";
import { Helmet } from "react-helmet-async";
import { getBlog } from "../api/endpoints";
import { useAsync } from "../hooks/useAsync";
import { useSite } from "../theme/context";
import { Section } from "../components/ui/Section";
import { SectionHeading } from "../components/ui/SectionHeading";
import { ErrorState } from "../components/ui/Loader";
import { SmartImage } from "../components/ui/SmartImage";
import { Reveal } from "../components/ui/Reveal";
import { formatTime } from "../lib/utils";
import { prefetchPost } from "../lib/prefetch";

export function Blog() {
  const [page, setPage] = useState(1);
  const { data, loading, error, reload } = useAsync(() => getBlog(page), [page], `blog:${page}`);
  const { data: site } = useSite();
  const meta = site?.sections.find((s) => s.key === "blog") ?? {
    heading: "Blogs & Articles",
    highlight_text: "Articles",
    sub_heading: "Guides and tips on photo editing and why quality matters.",
  };

  return (
    <>
      <Helmet><title>{meta.heading} — Photo Fix Zone</title></Helmet>

      <Section settings={meta.settings}>
        <SectionHeading heading={meta.heading} highlight={meta.highlight_text} sub={meta.sub_heading} />

        {!data && error ? (
          <ErrorState onRetry={reload} />
        ) : !data ? (
          <div className="grid gap-6 md:grid-cols-3">
            {Array.from({ length: 6 }).map((_, i) => (
              <div key={i} className="animate-pulse overflow-hidden rounded-[var(--pfz-radius-lg)] bg-canvas shadow-[var(--pfz-shadow-card)]">
                <div className="aspect-[16/10] bg-line" />
                <div className="space-y-3 p-5">
                  <div className="h-4 w-3/4 rounded bg-line" />
                  <div className="h-3 w-1/3 rounded bg-line" />
                </div>
              </div>
            ))}
          </div>
        ) : (
          <div className={loading ? "opacity-60 transition-opacity" : "transition-opacity"}>
            <div className="grid gap-6 md:grid-cols-3">
              {data.data.map((p, i) => (
                <Reveal
                  key={p.slug}
                  index={i}
                  as="article"
                  onMouseEnter={() => prefetchPost(p.slug)}
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

            {data.meta.last_page > 1 ? (
              <div className="mt-10 flex justify-center gap-2">
                {Array.from({ length: data.meta.last_page }).map((_, i) => (
                  <button
                    key={i}
                    onClick={() => setPage(i + 1)}
                    className={
                      "h-9 w-9 rounded-full text-sm font-semibold " +
                      (page === i + 1 ? "bg-primary text-on-primary" : "bg-alt text-muted")
                    }
                  >
                    {i + 1}
                  </button>
                ))}
              </div>
            ) : null}
          </div>
        )}
      </Section>
    </>
  );
}
