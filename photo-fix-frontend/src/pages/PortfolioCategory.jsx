import { Navigate, useParams } from "react-router-dom";
import { Helmet } from "react-helmet-async";
import { useSite } from "../theme/context";
import { PageHero } from "../components/ui/PageHero";
import { Section } from "../components/ui/Section";
import { SectionHeading } from "../components/ui/SectionHeading";
import { StaticCompare } from "../components/ui/StaticCompare";
import { ensureSamples } from "../lib/placeholderSamples";
import { Reveal } from "../components/ui/Reveal";
import { Button } from "../components/ui/Button";
import { CtaBand } from "../components/sections/CtaBand";

// "See Samples" on the Pricing page links here — same card design as each
// category section on the main Portfolio page (StaticCompare, no title
// captions), just for one category on its own page instead of all of them
// stacked on /portfolio.
export function PortfolioCategory() {
  const { slug } = useParams();
  const { data } = useSite();
  const categories = data?.content?.work_sample_categories ?? [];
  const category = categories.find((c) => c.slug === slug);

  if (!data) return null;
  if (!category) return <Navigate to="/portfolio" replace />;

  return (
    <>
      <Helmet>
        <title>{category.name} Work Samples — Pixel Graphic Studio</title>
        <meta name="description" content={category.description ?? ""} />
      </Helmet>
      <PageHero
        title={category.name}
        crumbs={[{ label: "Portfolio", to: "/portfolio" }, { label: category.name }]}
      />

      <Section>
        <SectionHeading
          heading={`${category.name} Work Samples`}
          highlight="Work Samples"
          sub={category.description}
        />

        <div className="grid gap-6 sm:grid-cols-2">
          {ensureSamples(category.samples, 4).map((s, i) => (
            <Reveal
              key={s.title ?? i}
              index={i}
              className="transition duration-300 hover:-translate-y-1"
            >
              <StaticCompare before={s.before_image} after={s.after_image} />
            </Reveal>
          ))}
        </div>

        <div className="mt-10 flex flex-wrap justify-center gap-3">
          <Button to={category.read_more.url} variant="outline">{category.read_more.label}</Button>
          <Button to={category.try_free.url} variant="primary">{category.try_free.label}</Button>
        </div>
      </Section>

      <CtaBand content={data?.content?.cta_perfection} />
    </>
  );
}
