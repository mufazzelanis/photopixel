import { Helmet } from "react-helmet-async";
import { Link } from "react-router-dom";
import { useSite } from "../theme/context";
import { PageHero } from "../components/ui/PageHero";
import { Section } from "../components/ui/Section";
import { Reveal } from "../components/ui/Reveal";
import { Icon } from "../lib/Icon";

export function Portfolio() {
  const { data } = useSite();
  const categories = data?.content?.work_sample_categories ?? [];

  return (
    <>
      <Helmet><title>Portfolio — Pixel Graphic Studio</title></Helmet>
      <PageHero
        title="Image Editing Portfolio"
        subtitle="Before / after from our satisfied clients — pick a category to see the full gallery."
        crumbs={[{ label: "Portfolio" }]}
      />

      <Section>
        {categories.length ? (
          <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            {categories.map((cat, i) => {
              const cover = cat.cover || cat.samples[0]?.after_image;
              return (
                <Reveal
                  key={cat.slug}
                  index={i}
                  as="article"
                  className="group overflow-hidden rounded-[var(--pfz-radius-lg)] bg-canvas shadow-[var(--pfz-shadow-card)] transition duration-300 hover:-translate-y-1.5 hover:shadow-[var(--pfz-shadow-glow)]"
                >
                  <Link to={`/portfolio/${cat.slug}`}>
                    <div className="relative aspect-[4/3] overflow-hidden bg-alt">
                      {cover ? (
                        <img
                          src={cover}
                          alt={cat.name}
                          loading="lazy"
                          className="h-full w-full object-cover transition duration-500 group-hover:scale-110"
                        />
                      ) : (
                        <div className="grid h-full w-full place-items-center text-primary/40">
                          <Icon name={cat.icon || "layers"} size={40} />
                        </div>
                      )}
                      <div className="absolute inset-0 bg-gradient-to-t from-heading/70 via-transparent to-transparent opacity-0 transition duration-300 group-hover:opacity-100" />
                      <span className="absolute right-3 top-3 rounded-full bg-heading/80 px-2.5 py-1 text-xs font-semibold text-white backdrop-blur">
                        {cat.samples.length} sample{cat.samples.length === 1 ? "" : "s"}
                      </span>
                      <span className="absolute left-3 top-3 grid h-9 w-9 place-items-center rounded-full pfz-gradient-brand text-white shadow-[var(--pfz-shadow-soft)]">
                        <Icon name={cat.icon || "layers"} size={18} />
                      </span>
                    </div>
                    <div className="flex items-center justify-between gap-3 p-5">
                      <h3 className="font-bold text-heading">{cat.name}</h3>
                      <span className="inline-flex shrink-0 items-center gap-1 text-sm font-semibold text-primary">
                        View
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round" className="transition duration-300 group-hover:translate-x-1">
                          <path d="M5 12h14M13 6l6 6-6 6" />
                        </svg>
                      </span>
                    </div>
                  </Link>
                </Reveal>
              );
            })}
          </div>
        ) : (
          <p className="text-center text-muted">Samples coming soon.</p>
        )}
      </Section>
    </>
  );
}
