import { useParams, Link } from "react-router-dom";
import { Helmet } from "react-helmet-async";
import { getPost } from "../api/endpoints";
import { useAsync } from "../hooks/useAsync";
import { Loader, ErrorState } from "../components/ui/Loader";
import { SmartImage } from "../components/ui/SmartImage";
import { formatDate } from "../lib/utils";

export function BlogPost() {
  const { slug } = useParams();
  const { data, loading, error, reload } = useAsync(() => getPost(slug), [slug]);

  if (loading) return <Loader label="Loading article" />;
  if (error) return <ErrorState onRetry={reload} />;

  return (
    <>
      <Helmet>
        <title>{data.seo?.title}</title>
        <meta name="description" content={data.seo?.description ?? ""} />
      </Helmet>

      <article className="pfz-section">
        <div className="pfz-container max-w-3xl">
          <Link to="/blog" className="text-sm font-semibold text-primary">← All articles</Link>
          <h1 className="mt-4 text-2xl font-extrabold text-heading sm:text-3xl md:text-4xl">{data.title}</h1>
          <p className="mt-2 text-sm text-muted">
            {data.author_name} · {formatDate(data.published_at)} · {data.read_time}
          </p>
          {data.cover ? (
            <SmartImage src={data.cover} alt={data.title} wrapperClassName="mt-6 aspect-[16/9] rounded-[var(--pfz-radius-lg)]" />
          ) : null}
          <div
            className="prose mt-8 max-w-none text-body [&_h2]:mt-8 [&_h2]:text-2xl [&_h2]:font-bold [&_h2]:text-heading [&_p]:mt-4 [&_p]:leading-relaxed [&_a]:text-primary"
            dangerouslySetInnerHTML={{ __html: data.body ?? "" }}
          />
        </div>
      </article>
    </>
  );
}
