import { Navigate, useParams } from "react-router-dom";
import { Helmet } from "react-helmet-async";
import { motion } from "framer-motion";
import { useSite } from "../theme/context";
import { PageHero } from "../components/ui/PageHero";
import { Section } from "../components/ui/Section";
import { SectionHeading } from "../components/ui/SectionHeading";
import { BeforeAfter } from "../components/ui/BeforeAfter";
import { Reveal } from "../components/ui/Reveal";
import { Button } from "../components/ui/Button";
import { CtaBand } from "../components/sections/CtaBand";
import { Icon } from "../lib/Icon";
import { prefersReducedMotion } from "../lib/utils";

export function PortfolioCategory() {
  const { slug } = useParams();
  const { data, animation } = useSite();
  const categories = data?.content?.work_sample_categories ?? [];
  const category = categories.find((c) => c.slug === slug);
  const motionOn = animation.enabled && !(animation.respect_reduced_motion && prefersReducedMotion());

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
            <Icon name={category.icon || "layers"} size={28} />
          </motion.span>
        </Reveal>

        <SectionHeading
          heading={`${category.name} Work Samples`}
          highlight="Work Samples"
          sub={category.description}
        />

        <div className="grid gap-6 sm:grid-cols-2">
          {category.samples.map((s, i) => (
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
          <Button to={category.read_more.url} variant="outline">{category.read_more.label}</Button>
          <Button to={category.try_free.url} variant="primary">{category.try_free.label}</Button>
        </div>
      </Section>

      <CtaBand content={data?.content?.cta_perfection} />
    </>
  );
}
