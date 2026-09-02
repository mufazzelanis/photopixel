import { useParams } from "react-router-dom";
import { Helmet } from "react-helmet-async";
import { getService } from "../api/endpoints";
import { useAsync } from "../hooks/useAsync";
import { PageHero } from "../components/ui/PageHero";
import { Loader, ErrorState } from "../components/ui/Loader";
import { BeforeAfter } from "../components/ui/BeforeAfter";
import { CmsButton } from "../components/ui/CmsButton";

export function ServiceDetail() {
  const { slug } = useParams();
  const { data, loading, error, reload } = useAsync(() => getService(slug), [slug]);

  if (loading) return <Loader label="Loading service" />;
  if (error) return <ErrorState onRetry={reload} />;

  return (
    <>
      <Helmet>
        <title>{data.seo?.title}</title>
        <meta name="description" content={data.seo?.description ?? ""} />
      </Helmet>
      <PageHero title={data.title} subtitle={data.short_desc} crumbs={[{ label: "Services", to: "/services" }, { label: data.title }]} />

      <section className="pfz-section">
        <div className="pfz-container grid items-start gap-8 lg:grid-cols-2 lg:gap-12">
          <BeforeAfter before={data.before_image} after={data.after_image} />
          <div>
            <ul className="mb-6 space-y-2.5">
              {(data.points ?? []).map((p) => (
                <li key={p} className="flex items-center gap-2 text-sm text-body">
                  <span className="grid h-5 w-5 place-items-center rounded-full bg-secondary text-white">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="3" strokeLinecap="round" strokeLinejoin="round"><path d="M20 6L9 17l-5-5" /></svg>
                  </span>
                  {p}
                </li>
              ))}
            </ul>
            <div
              className="prose max-w-none text-muted [&_h2]:mt-6 [&_h2]:text-xl [&_h2]:font-bold [&_h2]:text-heading"
              dangerouslySetInnerHTML={{ __html: data.long_desc || `<p>${data.short_desc ?? ""}</p>` }}
            />
            <CmsButton label="Get a quote" url="#quote" className="mt-8" />
          </div>
        </div>
      </section>

      {data.gallery?.length ? (
        <section className="bg-alt pfz-section">
          <div className="pfz-container grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            {data.gallery.map((g, i) => (
              <img key={i} src={g.url} alt="" loading="lazy" className="rounded-[var(--pfz-radius-md)] object-cover" />
            ))}
          </div>
        </section>
      ) : null}
    </>
  );
}
