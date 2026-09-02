import { Helmet } from "react-helmet-async";
import { useSite } from "../theme/context";
import { PageHero } from "../components/ui/PageHero";
import { ContactForm } from "../forms/ContactForm";
import { Icon } from "../lib/Icon";

export function Contact() {
  const { data } = useSite();
  const c = data?.footer?.contact ?? {};

  return (
    <>
      <Helmet><title>Contact — Photo Fix Zone</title></Helmet>
      <PageHero title="Contact Us" subtitle="Tell us about your project and we’ll reply within one business day." crumbs={[{ label: "Contact" }]} />

      <section className="pfz-section">
        <div className="pfz-container grid gap-12 lg:grid-cols-[1fr_1.4fr]">
          <div className="space-y-6">
            {[
              ["Address", c.address, "layers"],
              ["Email", c.email, "badge-check"],
              ["Phone", c.phone, "headset"],
            ].map(([label, value, icon]) => (
              <div key={label} className="flex gap-4">
                <span className="grid h-11 w-11 shrink-0 place-items-center rounded-[var(--pfz-radius-md)] bg-primary/10 text-primary">
                  <Icon name={icon} size={20} />
                </span>
                <div>
                  <p className="font-semibold text-heading">{label}</p>
                  <p className="text-sm text-muted">{value || "—"}</p>
                </div>
              </div>
            ))}
          </div>

          <div className="rounded-[var(--pfz-radius-lg)] bg-canvas p-6 shadow-[var(--pfz-shadow-card)] sm:p-8">
            <ContactForm />
          </div>
        </div>
      </section>
    </>
  );
}
