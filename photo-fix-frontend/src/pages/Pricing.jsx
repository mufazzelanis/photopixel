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

function PriceRow({ item, index }) {
  return (
    <Reveal
      index={Math.min(index, 8)}
      className="group flex items-center justify-between gap-3 rounded-[var(--pfz-radius-md)] border border-line bg-canvas px-4 py-3.5 transition-all duration-200 hover:-translate-y-0.5 hover:border-primary/40 hover:shadow-[var(--pfz-shadow-soft)] sm:px-5 sm:py-4"
    >
      <div className="flex min-w-0 items-center gap-3">
        <span className="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-primary/10 text-primary transition-colors duration-200 group-hover:bg-primary group-hover:text-white sm:h-9 sm:w-9">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="3" strokeLinecap="round" strokeLinejoin="round">
            <path d="M20 6L9 17l-5-5" />
          </svg>
        </span>
        <span className="text-[0.95rem] font-semibold leading-snug text-heading sm:text-base">
          {item.label}
        </span>
      </div>
      <span className="pfz-gradient-brand shrink-0 whitespace-nowrap rounded-[var(--pfz-radius-pill)] px-3.5 py-1.5 text-sm font-extrabold text-white shadow-[var(--pfz-shadow-soft)] sm:px-4 sm:py-2 sm:text-base">
        {item.price}
      </span>
    </Reveal>
  );
}

function PricingTable({ service, index }) {
  return (
    <Section settings={{ bg: index % 2 ? "bg-alt" : undefined }}>
      <Reveal className="mx-auto mb-8 flex max-w-2xl flex-col items-center gap-4 text-center sm:mb-10">
        <h3 className="text-2xl font-extrabold leading-tight text-heading sm:text-3xl md:text-[2.4rem]">
          {service.title}
        </h3>
        <div className="pfz-gradient-brand inline-flex flex-col items-center gap-0.5 rounded-[var(--pfz-radius-lg)] px-7 py-3 text-white shadow-[var(--pfz-shadow-glow)] sm:px-9 sm:py-4">
          <span className="text-[0.7rem] font-bold uppercase tracking-[0.18em] text-white/80 sm:text-xs">
            Starting At
          </span>
          <span className="text-3xl font-extrabold leading-none sm:text-4xl">
            {service.starting_price}
          </span>
        </div>
      </Reveal>

      <Reveal
        index={1}
        className="mx-auto max-w-5xl rounded-[var(--pfz-radius-lg)] border-2 border-primary/15 bg-canvas p-5 shadow-[var(--pfz-shadow-card)] sm:p-8"
      >
        {/* Big, unmissable before/after — its own full-width row instead of
            squeezed into a side column, so it never looks small next to a
            tall price list. */}
        <div className="mx-auto mb-8 max-w-xl sm:mb-10">
          <BeforeAfter before={service.before_image} after={service.after_image} />
          <div className="mt-5 flex flex-wrap justify-center gap-3">
            <Button to={service.samples_url} variant="outline">
              See Samples
            </Button>
            <Button to="/free-trial">Try For Free</Button>
          </div>
        </div>

        <div className="grid gap-3 sm:grid-cols-2 sm:gap-4">
          {service.items.map((item, i) => (
            <PriceRow key={i} item={item} index={i} />
          ))}
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
