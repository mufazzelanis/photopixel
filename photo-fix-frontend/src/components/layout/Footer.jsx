import { Link } from "react-router-dom";
import { useSite } from "../../theme/context";
import { Icon } from "../../lib/Icon";
import { NewsletterForm } from "../../forms/NewsletterForm";
import { Reveal } from "../ui/Reveal";

const CONTACT_ROWS = [
  { key: "address", label: "Our Address", d: "M12 21s-7-6.5-7-12a7 7 0 0 1 14 0c0 5.5-7 12-7 12z M12 9a2 2 0 1 0 .01 0" },
  { key: "email", label: "Our Email", d: "M3 6h18v12H3z M3 7l9 6 9-6" },
  { key: "phone", label: "Our Phone", d: "M4 4h5l2 5-3 2a12 12 0 0 0 6 6l2-3 5 2v5a2 2 0 0 1-2 2A16 16 0 0 1 2 6a2 2 0 0 1 2-2" },
];

function ContactStrip({ contact = {} }) {
  return (
    // Footer is global and sits after whatever section a given page ends
    // with, so this can't reach up into the previous section (that section's
    // own content isn't guaranteed to leave room) — the card stays inside
    // the footer's own top padding instead.
    <div className="pfz-container relative z-10 pt-10 sm:pt-14">
      <Reveal className="grid overflow-hidden rounded-[var(--pfz-radius-lg)] pfz-gradient-brand text-white shadow-[var(--pfz-shadow-card)] sm:grid-cols-3 sm:divide-x sm:divide-white/15">
        {CONTACT_ROWS.map((row) => (
          <div key={row.key} className="flex items-center gap-3 px-5 py-4 sm:px-6 sm:py-5">
            <span className="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-white/15">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round">
                {row.d.split(" M").map((seg, i) => (
                  <path key={i} d={i === 0 ? seg : "M" + seg} />
                ))}
              </svg>
            </span>
            <div className="min-w-0">
              <p className="text-sm font-bold">{row.label}</p>
              <p className="truncate text-xs text-white/85 sm:whitespace-normal">{contact[row.key] || "—"}</p>
            </div>
          </div>
        ))}
      </Reveal>
    </div>
  );
}

export function Footer() {
  const { data } = useSite();
  const f = data?.footer ?? {};
  const brand = data?.navigation?.brand ?? "Photo Fix Zone";

  return (
    <footer className="pfz-gradient-dark text-white/80">
      <ContactStrip contact={f.contact} />

      <div className="pfz-container grid gap-10 pt-10 pb-14 sm:grid-cols-2 sm:pt-12 lg:grid-cols-4 lg:gap-8">
        <div className="sm:col-span-2 lg:col-span-1">
          <div className="mb-4 flex items-center gap-2 text-lg font-extrabold text-white">
            <span className="grid h-9 w-9 shrink-0 place-items-center rounded-[var(--pfz-radius-sm)] pfz-gradient-brand">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2"><rect x="3" y="5" width="18" height="14" rx="3" /><circle cx="12" cy="12" r="3.2" /></svg>
            </span>
            {brand}
          </div>
          <p className="max-w-sm text-sm leading-relaxed">{f.about}</p>
          {f.payment_methods?.length ? (
            <div className="mt-5">
              <p className="mb-2 text-xs font-semibold uppercase tracking-wide text-white/60">We Accept</p>
              <div className="flex flex-wrap items-center gap-2">
                {f.payment_methods.map((p) =>
                  p.logo ? (
                    <span key={p.name} className="grid h-9 place-items-center rounded-md bg-white px-2">
                      <img src={p.logo} alt={p.name} className="h-6 w-auto max-w-[80px] object-contain" loading="lazy" />
                    </span>
                  ) : (
                    <span key={p.name} className="rounded-md bg-white/95 px-2.5 py-1.5 text-xs font-bold text-gray-700">
                      {p.name}
                    </span>
                  ),
                )}
              </div>
            </div>
          ) : null}
        </div>

        {(f.columns ?? []).map((col) => (
          <div key={col.title}>
            <h4 className="mb-4 font-semibold text-white">{col.title}</h4>
            <ul className="space-y-2 text-sm">
              {col.links.map((l) => (
                <li key={l.label}>
                  {l.url?.startsWith("/") ? (
                    <Link to={l.url} className="transition hover:text-white">{l.label}</Link>
                  ) : (
                    <a href={l.url} className="transition hover:text-white">{l.label}</a>
                  )}
                </li>
              ))}
            </ul>
          </div>
        ))}

        <div>
          <h4 className="mb-4 font-semibold text-white">{f.newsletter?.heading ?? "Subscribe Now"}</h4>
          <NewsletterForm
            placeholder={f.newsletter?.placeholder}
            buttonLabel={f.newsletter?.button_label}
          />
          {f.socials?.length ? (
            <div className="mt-5 flex flex-wrap gap-2">
              {f.socials.map((s) => (
                <a
                  key={s.platform}
                  href={s.url}
                  target="_blank"
                  rel="noopener noreferrer"
                  aria-label={s.platform}
                  className="grid h-9 w-9 place-items-center rounded-full bg-white/10 text-white transition hover:bg-primary"
                >
                  <Icon name={s.icon} size={16} />
                </a>
              ))}
            </div>
          ) : null}
        </div>
      </div>

      <div className="border-t border-white/10 py-5 text-center text-xs text-white/60">
        {f.copyright}
      </div>
    </footer>
  );
}
