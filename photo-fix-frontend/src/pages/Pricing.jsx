import { Fragment } from "react";
import { Helmet } from "react-helmet-async";
import { getPricing } from "../api/endpoints";
import { useAsync } from "../hooks/useAsync";
import { useSite } from "../theme/context";
import { Section } from "../components/ui/Section";
import { SectionHeading } from "../components/ui/SectionHeading";
import { Loader, ErrorState } from "../components/ui/Loader";
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
          {service.title} <span className="pfz-text-gradient">Starts at {service.starting_price}</span>
        </h3>
        <div className="mx-auto mt-3 flex items-center justify-center gap-1">
          <span className="h-1.5 w-1.5 rounded-full bg-primary/40" />
          <span className="h-1.5 w-1.5 rounded-full bg-primary/40" />
          <span className="h-1.5 w-1.5 rounded-full bg-primary/40" />
          <span className="h-0.5 w-10 rounded-full bg-primary" />
        </div>
      </Reveal>

      <Reveal
        index={1}
        className="mx-auto max-w-4xl rounded-[var(--pfz-radius-lg)] border-2 border-primary/20 p-5 sm:p-7"
      >
        <div className="grid gap-6 lg:grid-cols-[minmax(0,1fr)_1.4fr] lg:gap-10">
          <div>
            <BeforeAfter before={service.before_image} after={service.after_image} />
            <Button to={service.samples_url} variant="outline" size="sm" className="mt-4">
              See Samples
            </Button>
          </div>

          <div className="flex flex-col">
            <div className="grid grid-cols-[1fr_auto] gap-x-4 gap-y-2.5 sm:gap-x-8">
              {service.items.map((item, i) => (
                <Fragment key={i}>
                  <div className="flex items-center gap-2 text-sm text-body">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round" className="shrink-0 text-secondary">
                      <path d="M20 6L9 17l-5-5" />
                    </svg>
                    {item.label}
                  </div>
                  <div className="flex items-center gap-1 whitespace-nowrap text-sm font-bold text-heading">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" className="text-muted">
                      <path d="M5 12h14M13 6l6 6-6 6" />
                    </svg>
                    {item.price}
                  </div>
                </Fragment>
              ))}
            </div>
            <Button to="/free-trial" size="sm" className="mt-6 self-start">
              Try For Free
            </Button>
          </div>
        </div>
      </Reveal>
    </Section>
  );
}

export function Pricing() {
  const { data, loading, error, reload } = useAsync(getPricing, []);
  const { data: site } = useSite();

  if (loading) return <Loader label="Loading pricing" />;
  if (error) return <ErrorState onRetry={reload} />;

  const faqMeta = site?.sections.find((s) => s.key === "faq") ?? {};

  return (
    <>
      <Helmet>
        <title>{data.seo?.title ?? "Pricing — Photo Fix Zone"}</title>
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
