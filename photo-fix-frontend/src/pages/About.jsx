import { Helmet } from "react-helmet-async";
import { getAbout } from "../api/endpoints";
import { useAsync } from "../hooks/useAsync";
import { ErrorState } from "../components/ui/Loader";
import { PageSkeleton } from "../components/ui/Skeleton";
import { AboutHero } from "../components/about/AboutHero";
import { AboutBoost } from "../components/about/AboutBoost";
import { AboutTextMedia } from "../components/about/AboutTextMedia";
import { AboutPartnership } from "../components/about/AboutPartnership";

export function About() {
  const { data, error, reload } = useAsync(getAbout, [], "about");

  if (!data) return error ? <ErrorState onRetry={reload} /> : <PageSkeleton />;

  const { seo, hero, boost, post_production: pp, society, partnership } = data;

  return (
    <>
      <Helmet>
        <title>{seo?.title}</title>
        <meta name="description" content={seo?.description ?? ""} />
        {seo?.robots ? <meta name="robots" content={seo.robots} /> : null}
      </Helmet>

      <AboutHero data={hero} />
      <AboutBoost data={boost} />

      <AboutTextMedia
        id="about-post-production"
        bg="bg-alt"
        heading={pp.heading}
        highlight={pp.highlight}
        paragraphs={[pp.body_1, pp.body_2]}
        btn={pp.btn}
        image={pp.image}
      />

      <AboutTextMedia
        id="about-society"
        bg="base"
        heading={society.heading}
        highlight={society.highlight}
        paragraphs={[society.body_1, society.body_2, society.body_3]}
        image={society.image}
        flip
      />

      <AboutPartnership data={partnership} />
    </>
  );
}
