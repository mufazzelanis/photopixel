import { Helmet } from "react-helmet-async";
import { PageHero } from "../components/ui/PageHero";
import { CmsButton } from "../components/ui/CmsButton";
import { Reveal } from "../components/ui/Reveal";

const TIERS = [
  { name: "Basic", note: "Background removal & simple clipping path", price: "from $0.39", features: ["Simple paths", "24h delivery", "Bulk discounts"] },
  { name: "Standard", note: "Retouching, masking, ghost mannequin", price: "from $0.99", features: ["Multiple paths", "12h delivery", "Unlimited revisions"], featured: true },
  { name: "Advanced", note: "High-end retouch, color grade, jewellery", price: "custom", features: ["Complex masking", "Priority queue", "Dedicated editor"] },
];

export function Pricing() {
  return (
    <>
      <Helmet><title>Pricing — Photo Fix Zone</title></Helmet>
      <PageHero title="Simple, Budget-Friendly Pricing" subtitle="Pay per image. The more you send, the less you pay." crumbs={[{ label: "Pricing" }]} />

      <section className="pfz-section">
        <div className="pfz-container grid gap-6 md:grid-cols-3">
          {TIERS.map((t, i) => (
            <Reveal
              key={t.name}
              index={i}
              className={
                "rounded-[var(--pfz-radius-lg)] border p-7 shadow-[var(--pfz-shadow-soft)] " +
                (t.featured ? "border-primary bg-primary/5" : "border-line bg-canvas")
              }
            >
              <h3 className="text-lg font-bold text-heading">{t.name}</h3>
              <p className="mt-1 text-sm text-muted">{t.note}</p>
              <p className="mt-4 text-3xl font-extrabold text-heading">{t.price}</p>
              <ul className="mt-4 space-y-2 text-sm text-body">
                {t.features.map((f) => (
                  <li key={f} className="flex items-center gap-2">
                    <span className="grid h-5 w-5 place-items-center rounded-full bg-secondary text-white">
                      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="3" strokeLinecap="round" strokeLinejoin="round"><path d="M20 6L9 17l-5-5" /></svg>
                    </span>
                    {f}
                  </li>
                ))}
              </ul>
              <CmsButton label="Get a quote" url="#quote" className="mt-6 w-full" variant={t.featured ? "primary" : "outline"} />
            </Reveal>
          ))}
        </div>
      </section>
    </>
  );
}
