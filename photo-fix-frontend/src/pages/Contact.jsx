import { Helmet } from "react-helmet-async";
import { useSite } from "../theme/context";
import { Section } from "../components/ui/Section";
import { SectionHeading } from "../components/ui/SectionHeading";
import { Reveal } from "../components/ui/Reveal";
import { SmartImage } from "../components/ui/SmartImage";
import { ContactForm } from "../forms/ContactForm";
import { ContactIllustration } from "../components/ui/ContactIllustration";
import { Icon } from "../lib/Icon";

// A handful of brand-ish colors so "Follow Us On Socials" doesn't render
// every platform in the same flat tint.
const SOCIAL_COLORS = {
  facebook: "#1877F2",
  linkedin: "#0A66C2",
  x: "#0F172A",
  instagram: "linear-gradient(135deg, #F59E0B, #EC4899, #8B5CF6)",
  youtube: "#EF4444",
  star: "#0F172A",
};

export function Contact() {
  const { data } = useSite();
  const meta = data?.sections.find((s) => s.key === "contact") ?? {};
  const c = data?.footer?.contact ?? {};
  const socials = data?.footer?.socials ?? [];

  return (
    <>
      <Helmet><title>{meta.heading ?? "Contact Us"} — Photo Fix Zone</title></Helmet>

      <Section settings={meta.settings}>
        <SectionHeading heading={meta.heading} highlight={meta.highlight_text} sub={meta.sub_heading} />
      </Section>

      <Section>
        <div className="grid items-center gap-10 lg:grid-cols-2 lg:gap-16">
          <Reveal>
            {meta.image ? (
              <SmartImage
                src={meta.image}
                alt=""
                wrapperClassName="mx-auto max-w-sm rounded-[var(--pfz-radius-lg)] bg-alt"
              />
            ) : (
              <ContactIllustration className="mx-auto max-w-sm" />
            )}
          </Reveal>
          <Reveal index={1} className="rounded-[var(--pfz-radius-lg)] bg-canvas p-6 shadow-[var(--pfz-shadow-card)] sm:p-8">
            <ContactForm />
          </Reveal>
        </div>
      </Section>

      <Section settings={{ bg: "bg-alt" }}>
        <div className="grid items-center gap-10 lg:grid-cols-2 lg:gap-16">
          <Reveal>
            <h2 className="text-2xl font-extrabold text-heading sm:text-3xl">
              Office <span className="pfz-text-gradient">Address</span>
            </h2>
            <p className="mt-5 font-semibold text-heading">Head Office &amp; Production House:</p>
            <p className="mt-2 whitespace-pre-line text-muted">{c.address || "—"}</p>
          </Reveal>
          <Reveal index={1} className="overflow-hidden rounded-[var(--pfz-radius-lg)] shadow-[var(--pfz-shadow-card)]">
            {c.map_embed_url ? (
              <iframe
                src={c.map_embed_url}
                className="h-72 w-full border-0"
                loading="lazy"
                referrerPolicy="no-referrer-when-downgrade"
                title="Office location"
              />
            ) : (
              <div className="grid h-72 place-items-center bg-canvas text-sm text-muted">Map coming soon</div>
            )}
          </Reveal>
        </div>
      </Section>

      {socials.length ? (
        <Section>
          <Reveal className="text-center">
            <h2 className="text-2xl font-extrabold text-heading sm:text-3xl">
              Follow Us On <span className="pfz-text-gradient">Socials</span>
            </h2>
            <p className="mt-2 text-sm text-muted">Let&rsquo;s connect with us, to get our all updates</p>
          </Reveal>
          <Reveal index={1} className="mt-8 flex flex-wrap justify-center gap-4">
            {socials.map((s) => (
              <a
                key={s.platform}
                href={s.url}
                target="_blank"
                rel="noopener noreferrer"
                aria-label={s.platform}
                className="grid h-14 w-14 place-items-center rounded-full text-white shadow-[var(--pfz-shadow-card)] transition hover:-translate-y-1 hover:shadow-[var(--pfz-shadow-glow)]"
                style={{ background: SOCIAL_COLORS[s.icon] ?? "var(--pfz-color-primary)" }}
              >
                <Icon name={s.icon} size={22} />
              </a>
            ))}
          </Reveal>
        </Section>
      ) : null}
    </>
  );
}
