import { Helmet } from "react-helmet-async";
import { useSite } from "../theme/context";
import { PageHero } from "../components/ui/PageHero";
import { BeforeAfter } from "../components/ui/BeforeAfter";
import { Reveal } from "../components/ui/Reveal";

export function Portfolio() {
  const { data } = useSite();
  const samples = data?.content?.work_samples ?? [];

  return (
    <>
      <Helmet><title>Portfolio — Photo Fix Zone</title></Helmet>
      <PageHero title="Work Samples" subtitle="Before / after from our satisfied clients." crumbs={[{ label: "Portfolio" }]} />

      <section className="pfz-section">
        <div className="pfz-container grid gap-8 sm:grid-cols-2">
          {samples.length ? (
            samples.map((s, i) => (
              <Reveal key={i} index={i}>
                <BeforeAfter before={s.before_image} after={s.after_image} />
                {s.title ? <p className="mt-2 text-center text-sm text-muted">{s.title}</p> : null}
              </Reveal>
            ))
          ) : (
            <p className="text-muted">Samples coming soon.</p>
          )}
        </div>
      </section>
    </>
  );
}
