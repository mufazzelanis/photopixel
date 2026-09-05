import { useParams } from "react-router-dom";
import { Helmet } from "react-helmet-async";
import { motion } from "framer-motion";
import { getService } from "../api/endpoints";
import { useAsync } from "../hooks/useAsync";
import { useSite } from "../theme/context";
import { PageHero } from "../components/ui/PageHero";
import { Section } from "../components/ui/Section";
import { SectionHeading } from "../components/ui/SectionHeading";
import { ErrorState } from "../components/ui/Loader";
import { PageSkeleton } from "../components/ui/Skeleton";
import { BeforeAfter } from "../components/ui/BeforeAfter";
import { CmsButton } from "../components/ui/CmsButton";
import { Reveal } from "../components/ui/Reveal";
import { Button } from "../components/ui/Button";
import { CtaBand } from "../components/sections/CtaBand";
import { Icon } from "../lib/Icon";
import { prefersReducedMotion } from "../lib/utils";

export function ServiceDetail() {
  const { slug } = useParams();
  const { data, error, reload } = useAsync(() => getService(slug), [slug], `service:${slug}`);
  const { data: site, animation } = useSite();
  const motionOn = animation.enabled && !(animation.respect_reduced_motion && prefersReducedMotion());

  if (!data) return error ? <ErrorState onRetry={reload} /> : <PageSkeleton />;

  const samples = data.work_samples;

  return (
    <>
      <Helmet>
        <title>{data.seo?.title}</title>
        <meta name="description" content={data.seo?.description ?? ""} />
      </Helmet>
      <PageHero title={data.title} subtitle={data.short_desc} />

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

      {samples ? (
        <Section settings={{ bg: "bg-alt" }}>
          <Reveal className="mx-auto mb-4 flex justify-center">
            <motion.span
              className="grid h-16 w-16 place-items-center rounded-full pfz-gradient-brand text-white shadow-[var(--pfz-shadow-glow)]"
              animate={
                motionOn
                  ? { boxShadow: ["0 0 0 0 rgba(108,76,241,0.45)", "0 0 0 14px rgba(108,76,241,0)", "0 0 0 0 rgba(108,76,241,0)"] }
                  : undefined
              }
              transition={motionOn ? { duration: 2.2, repeat: Infinity, repeatDelay: 1.6, ease: "easeOut" } : undefined}
            >
              <Icon name={data.icon || "layers"} size={28} />
            </motion.span>
          </Reveal>

          <SectionHeading
            heading={`${samples.name} Work Samples`}
            highlight="Work Samples"
            sub={samples.description}
          />

          {samples.samples.length ? (
            <div className="grid gap-6 sm:grid-cols-2">
              {samples.samples.map((s, i) => (
                <Reveal key={s.title ?? i} index={i} className="transition duration-300 hover:-translate-y-1">
                  <BeforeAfter before={s.before_image} after={s.after_image} />
                  {s.title ? <p className="mt-2 text-center text-sm text-muted">{s.title}</p> : null}
                </Reveal>
              ))}
            </div>
          ) : (
            <p className="text-center text-muted">Samples for this category are coming soon.</p>
          )}

          <div className="mt-10 flex flex-wrap justify-center gap-3">
            <Button to={samples.read_more.url} variant="outline">{samples.read_more.label}</Button>
            <Button to={samples.try_free.url} variant="primary">{samples.try_free.label}</Button>
          </div>
        </Section>
      ) : null}

      <CtaBand content={site?.content?.cta_perfection} />
    </>
  );
}
