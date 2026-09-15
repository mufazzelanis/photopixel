import { Helmet } from "react-helmet-async";
import { useSite } from "../theme/context";
import { PageHero } from "../components/ui/PageHero";
import { Section } from "../components/ui/Section";
import { SectionHeading } from "../components/ui/SectionHeading";
import { Reveal } from "../components/ui/Reveal";
import { BeforeAfter } from "../components/ui/BeforeAfter";
import { Button } from "../components/ui/Button";
import { SamplePlaceholderGrid } from "../components/ui/SamplePlaceholderGrid";
import { ensureSamples } from "../lib/placeholderSamples";
import { CtaBand } from "../components/sections/CtaBand";
import { Stats } from "../components/sections/Stats";

function CategorySection({ category, index }) {
  return (
    <Section settings={{ bg: index % 2 ? "bg-alt" : undefined }}>
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
            <BeforeAfter before={s.before_image} after={s.after_image} />
            {s.title ? <p className="mt-2 text-center text-sm text-muted">{s.title}</p> : null}
          </Reveal>
        ))}
      </div>

      <div className="mt-10 flex flex-wrap justify-center gap-3">
        <Button to={category.read_more.url} variant="outline">
          {category.read_more.label}
        </Button>
        <Button to={category.try_free.url} variant="primary">
          {category.try_free.label}
        </Button>
      </div>
    </Section>
  );
}

export function Portfolio() {
  const { data } = useSite();
  const categories = data?.content?.work_sample_categories ?? [];
  const statsMeta = data?.sections.find((s) => s.key === "stats") ?? {};

  return (
    <>
      <Helmet>
        <title>Portfolio — Pixel Graphic Studio</title>
        <meta
          name="description"
          content="Before / after work samples from every image editing service — clipping path, ghost mannequin, retouching, color correction and more."
        />
      </Helmet>
      <PageHero title="Image Editing Portfolio" crumbs={[{ label: "Portfolio" }]} />

      {categories.length ? (
        categories.map((cat, i) => (
          <CategorySection key={cat.slug} category={cat} index={i} />
        ))
      ) : (
        <Section>
          <SamplePlaceholderGrid count={3} />
        </Section>
      )}

      <CtaBand content={data?.content?.cta_perfection} />

      {data?.content?.stats?.length ? (
        <Stats meta={statsMeta} content={data.content.stats} />
      ) : null}
    </>
  );
}
