import { Link } from "react-router-dom";
import { useSite } from "../../theme/context";
import { Icon } from "../../lib/Icon";
import { NewsletterForm } from "../../forms/NewsletterForm";
import { Reveal } from "../ui/Reveal";

/* ------------------------------------------------------------------ *
 * Contact strip — gradient card at the top of the footer.
 * It overlaps ONLY the footer's own light "shelf" band (never a real
 * content section), so it can't ride up over anything on any page.
 * Address / Email / Phone come from Settings › Contact.
 * ------------------------------------------------------------------ */
const CONTACT_ROWS = [
  {
    key: "address",
    label: "Our Address",
    href: () => null,
    d: "M4 12l8-7 8 7 M6 10.5V20h12v-9.5 M10.5 20v-5h3v5",
  },
  {
    key: "email",
    label: "Our Email",
    href: (v) => (v ? `mailto:${v}` : null),
    d: "M3 6h18v12H3z M3 7l9 6 9-6",
  },
  {
    key: "phone",
    label: "Our Phone",
    href: (v) => (v ? `tel:${v.replace(/[^\d+]/g, "")}` : null),
    d: "M4 4h5l2 5-3 2a12 12 0 0 0 6 6l2-3 5 2v5a2 2 0 0 1-2 2A16 16 0 0 1 2 6a2 2 0 0 1 2-2",
  },
];

/** Solid brand fills for known social platforms; star/other = outline. */
const SOCIAL_BG = {
  facebook: "bg-[#1877f2]",
  linkedin: "bg-[#0a66c2]",
  x: "bg-black",
  twitter: "bg-black",
  instagram: "bg-[#e1306c]",
  youtube: "bg-[#ff0000]",
};

function StrokeIcon({ d, className }) {
  return (
    <svg
      viewBox="0 0 24 24"
      fill="none"
      stroke="currentColor"
      strokeWidth="1.6"
      strokeLinecap="round"
      strokeLinejoin="round"
      className={className}
    >
      {d.split(" M").map((seg, i) => (
        <path key={i} d={i === 0 ? seg : "M" + seg} />
      ))}
    </svg>
  );
}

function ContactStrip({ contact = {} }) {
  return (
    <div className="pfz-container relative z-10 -mt-12 sm:-mt-16 lg:-mt-20">
      <Reveal className="grid grid-cols-1 divide-y divide-white/15 overflow-hidden rounded-[var(--pfz-radius-lg)] pfz-gradient-brand text-white shadow-[0_24px_50px_-16px_rgba(47,107,255,0.5)] sm:grid-cols-3 sm:divide-y-0">
        {CONTACT_ROWS.map((row, i) => {
          const value = contact[row.key];
          const href = row.href(value);
          const body = (
            <>
              <StrokeIcon
                d={row.d}
                className="h-9 w-9 shrink-0 text-white/95 sm:h-11 sm:w-11"
              />
              <span className="min-w-0">
                <span className="block text-base font-bold leading-tight sm:text-lg">
                  {row.label}
                </span>
                <span className="mt-1 block break-words text-[0.82rem] leading-snug text-white/85 sm:text-sm">
                  {value || "—"}
                </span>
              </span>
            </>
          );
          const cls =
            "relative flex items-center gap-4 px-5 py-5 transition-colors sm:px-7 sm:py-8";
          const divider =
            i > 0 ? (
              <span className="absolute left-0 top-1/2 hidden h-14 w-px -translate-y-1/2 bg-white/25 sm:block" />
            ) : null;
          return href ? (
            <a key={row.key} href={href} className={`${cls} hover:bg-white/10`}>
              {divider}
              {body}
            </a>
          ) : (
            <div key={row.key} className={cls}>
              {divider}
              {body}
            </div>
          );
        })}
      </Reveal>
    </div>
  );
}

/* ------------------------------------------------------------------ */

function FooterLink({ url, target, children }) {
  const cls = "text-[0.95rem] text-white/60 transition-colors hover:text-white";
  if (url?.startsWith("/")) {
    return (
      <Link to={url} className={cls}>
        {children}
      </Link>
    );
  }
  return (
    <a
      href={url}
      target={target === "_blank" ? "_blank" : undefined}
      rel={target === "_blank" ? "noopener noreferrer" : undefined}
      className={cls}
    >
      {children}
    </a>
  );
}

export function Footer() {
  const { data } = useSite();
  const f = data?.footer ?? {};
  const brand = data?.navigation?.brand ?? "Photo Fix Zone";
  const columns = Array.isArray(f.columns) ? f.columns : [];
  const socials = Array.isArray(f.socials) ? f.socials : [];
  const payments = Array.isArray(f.payment_methods) ? f.payment_methods : [];

  return (
    <footer className="relative">
      {/* light shelf — the strip's upper half overlaps onto this, exactly
          like the reference, without ever covering a content section */}
      <div className="h-20 bg-alt sm:h-24 lg:h-28" />

      <div className="bg-[#1d1d1f] text-white/70">
        <ContactStrip contact={f.contact} />

        <div className="pfz-container grid grid-cols-1 gap-8 pt-14 pb-12 sm:grid-cols-2 sm:gap-10 lg:grid-cols-[1.7fr_1fr_1fr_1.6fr]">
          {/* Brand */}
          <Reveal className="sm:col-span-2 lg:col-span-1">
            <div className="mb-5 flex items-center gap-2.5">
              <span className="grid h-10 w-10 shrink-0 place-items-center rounded-[var(--pfz-radius-sm)] bg-accent text-white">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                  <rect x="3" y="5" width="18" height="14" rx="3" />
                  <circle cx="12" cy="12" r="3.2" />
                </svg>
              </span>
              <span className="pfz-text-gradient text-xl font-extrabold sm:text-2xl">
                {brand}
              </span>
            </div>
            <p className="max-w-sm text-[0.95rem] leading-relaxed text-white/55">
              {f.about}
            </p>

            {payments.length ? (
              <div className="mt-6 flex flex-wrap items-center gap-2">
                {payments.map((p) =>
                  p.logo ? (
                    <span key={p.name} className="grid h-9 place-items-center rounded-md bg-white px-2">
                      <img
                        src={p.logo}
                        alt={p.name}
                        className="h-6 w-auto max-w-[80px] object-contain"
                        loading="lazy"
                      />
                    </span>
                  ) : (
                    <span
                      key={p.name}
                      className="rounded-md bg-white/95 px-2.5 py-1.5 text-xs font-bold text-gray-700"
                    >
                      {p.name}
                    </span>
                  ),
                )}
              </div>
            ) : null}
          </Reveal>

          {/* Link columns */}
          {columns.map((col, i) => (
            <Reveal key={col.title} index={i + 1}>
              <h4 className="mb-5 text-lg font-bold text-white! sm:text-xl">{col.title}</h4>
              <ul className="space-y-3">
                {(col.links ?? []).map((l) => (
                  <li key={l.label}>
                    <FooterLink url={l.url} target={l.target}>
                      {l.label}
                    </FooterLink>
                  </li>
                ))}
              </ul>
            </Reveal>
          ))}

          {/* Newsletter + socials */}
          <Reveal index={columns.length + 1} className="sm:col-span-2 lg:col-span-1">
            <h4 className="mb-5 text-lg font-bold text-white! sm:text-xl">
              {f.newsletter?.heading ?? "Subscribe Now"}
            </h4>
            <div className="max-w-md">
              <NewsletterForm
                solid
                placeholder={f.newsletter?.placeholder}
                buttonLabel={f.newsletter?.button_label}
              />
            </div>

            {socials.length ? (
              <div className="mt-5 flex flex-wrap gap-3">
                {socials.map((s) => {
                  const key = (s.icon || s.platform || "").toLowerCase();
                  const fill = SOCIAL_BG[key];
                  return (
                    <a
                      key={s.platform}
                      href={s.url}
                      target="_blank"
                      rel="noopener noreferrer"
                      aria-label={s.platform}
                      className={`grid h-10 w-10 place-items-center rounded-full text-white transition hover:-translate-y-0.5 ${
                        fill ?? "border border-white/40 text-white/80 hover:bg-white/10"
                      }`}
                    >
                      <Icon name={s.icon} size={17} />
                    </a>
                  );
                })}
              </div>
            ) : null}
          </Reveal>
        </div>

        {/* Bottom bar */}
        <div className="border-t border-white/10">
          <div className="pfz-container py-5 text-center text-xs text-white/45">
            {f.copyright ||
              `© ${new Date().getFullYear()} ${brand}. All rights reserved.`}
          </div>
        </div>
      </div>
    </footer>
  );
}
