import { Fragment } from "react";
import { Helmet } from "react-helmet-async";
import { getPricing } from "../api/endpoints";
import { useAsync } from "../hooks/useAsync";
import { useSite } from "../theme/context";
import { Section } from "../components/ui/Section";
import { SectionHeading } from "../components/ui/SectionHeading";
import { ErrorState } from "../components/ui/Loader";
import { PageSkeleton } from "../components/ui/Skeleton";
import { BeforeAfter } from "../components/ui/BeforeAfter";
import { Reveal } from "../components/ui/Reveal";
import { Button } from "../components/ui/Button";
import { Faq } from "../components/sections/Faq";
import { CtaBand } from "../components/sections/CtaBand";

function PricingTable({ service, index }) {
  return (
    <Section settings={{ bg: index % 2 ? "bg-alt" : undefined }}>
      <Reveal className="mx-auto mb-8 max-w-2xl text-center">
        <h3 className="text-xl font-extrabold text-heading sm:text-2xl">
          {service.title} <span className="text-secondary">Starts at {service.starting_price}</span>
        </h3>
        <div className="mx-auto mt-3 flex items-center justify-center gap-1">
          <span className="h-1.5 w-1.5 rounded-full bg-secondary/40" />
          <span className="h-1.5 w-1.5 rounded-full bg-secondary/40" />
          <span className="h-1.5 w-1.5 rounded-full bg-secondary/40" />
          <span className="h-0.5 w-10 rounded-full bg-secondary" />
        </div>
      </Reveal>

      <Reveal
        index={1}
        className="mx-auto max-w-4xl rounded-[var(--pfz-radius-lg)] border-2 border-secondary p-5 sm:p-7"
      >
        <div className="grid gap-6 lg:grid-cols-[minmax(0,1fr)_1.4fr]">
          {/* Three visually distinct panels (image | checklist | price),
              each divided by a continuous vertical line, matching the
              reference exactly — not just a gap. CSS grid already stretches
              both outer columns to equal height (the taller price list sets
              it); each is a flex column with mt-auto on its button, so both
              buttons land on the same shared bottom edge — WITHOUT
              stretching/cropping the photo itself to force it. A service
              with no real photo yet falls back to the placeholder square,
              which needs its own real proportions to still look like a
              photo instead of a broken flat color block. */}
          <div className="flex h-full flex-col gap-4 lg:border-r lg:border-secondary/25 lg:pr-6">
            <BeforeAfter before={service.before_image} after={service.after_image} />
            <Button
              to={service.samples_url}
              variant="outline"
              size="sm"
              className="mt-auto self-start uppercase tracking-wide !border-secondary !text-secondary hover:!bg-secondary hover:!text-white"
            >
              See Samples
            </Button>
          </div>

          <div className="flex h-full flex-col gap-6 lg:pl-6">
            <div className="grid grid-cols-[1fr_auto] gap-y-0">
              {service.items.map((item, i) => (
                <Fragment key={i}>
                  <div className="flex items-center gap-2 border-r border-secondary/25 py-1.5 pr-4 text-sm text-body sm:pr-6">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="shrink-0 text-secondary">
                      <circle cx="12" cy="12" r="9" />
                      <path d="M8.5 12.3l2.2 2.2 4.8-5" />
                    </svg>
                    {item.label}
                  </div>
                  <div className="flex items-center gap-1 whitespace-nowrap py-1.5 pl-4 text-sm font-bold text-heading sm:pl-6">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" className="text-muted">
                      <path d="M5 12h14M13 6l6 6-6 6" />
                    </svg>
                    {item.price}
                  </div>
                </Fragment>
              ))}
            </div>
            <Button to="/free-trial" size="sm" className="mt-auto self-start">
              Try For Free
            </Button>
          </div>
        </div>
      </Reveal>
    </Section>
  );
}

export function Pricing() {
  const { data, error, reload } = useAsync(getPricing, [], "pricing");
  const { data: site } = useSite();

  if (!data) return error ? <ErrorState onRetry={reload} /> : <PageSkeleton />;

  const faqMeta = site?.sections.find((s) => s.key === "faq") ?? {};

  return (
    <>
      <Helmet>
        <title>{data.seo?.title ?? "Pricing — Pixel Graphic Studio"}</title>
        <meta name="description" content={data.seo?.description ?? ""} />
      </Helmet>

      <Section>
        <SectionHeading heading={data.heading} highlight={data.highlight} sub={data.sub_text} />
      </Section>

      {data.services.map((service, i) => (
        <PricingTable key={service.slug} service={service} index={i} />
      ))}

      <CtaBand content={site?.content?.cta_perfection} />

      {data.faqs?.length ? (
        <Faq
          meta={{
            heading: faqMeta.heading ?? "Questions Our Clients Ask Frequently",
            highlight_text: faqMeta.highlight_text ?? "Ask Frequently",
          }}
          content={data.faqs}
        />
      ) : null}
    </>
  );
}
