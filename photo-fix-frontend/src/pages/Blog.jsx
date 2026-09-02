import { useState } from "react";
import { Link } from "react-router-dom";
import { Helmet } from "react-helmet-async";
import { getBlog } from "../api/endpoints";
import { useAsync } from "../hooks/useAsync";
import { PageHero } from "../components/ui/PageHero";
import { Loader, ErrorState } from "../components/ui/Loader";
import { SmartImage } from "../components/ui/SmartImage";
import { Reveal } from "../components/ui/Reveal";
import { formatDate } from "../lib/utils";

export function Blog() {
  const [page, setPage] = useState(1);
  const { data, loading, error, reload } = useAsync(() => getBlog(page), [page]);

  return (
    <>
      <Helmet><title>Blogs & Articles — Photo Fix Zone</title></Helmet>
      <PageHero title="Blogs & Articles" subtitle="Guides and tips on photo editing and why quality matters." crumbs={[{ label: "Blog" }]} />

      <section className="pfz-section">
        <div className="pfz-container">
          {loading ? (
            <Loader label="Loading articles" />
          ) : error ? (
            <ErrorState onRetry={reload} />
          ) : (
            <>
              <div className="grid gap-6 md:grid-cols-3">
                {data.data.map((p, i) => (
                  <Reveal key={p.slug} index={i} as="article" className="overflow-hidden rounded-[var(--pfz-radius-lg)] bg-canvas shadow-[var(--pfz-shadow-card)]">
                    <Link to={`/blog/${p.slug}`}>
                      <SmartImage src={p.cover} alt={p.title} wrapperClassName="aspect-[16/10] bg-alt" />
                    </Link>
                    <div className="p-5">
                      {p.category ? <span className="text-xs font-semibold uppercase tracking-wide text-primary">{p.category}</span> : null}
                      <h3 className="mt-1 text-base font-bold leading-snug text-heading">
                        <Link to={`/blog/${p.slug}`}>{p.title}</Link>
                      </h3>
                      <p className="mt-2 text-sm text-muted line-clamp-3">{p.excerpt}</p>
                      <p className="mt-3 text-xs text-muted">{formatDate(p.published_at)} · {p.read_time}</p>
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
            </>
          )}
        </div>
      </section>
    </>
  );
}
