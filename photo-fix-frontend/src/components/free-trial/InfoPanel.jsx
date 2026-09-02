import { Icon } from "../../lib/Icon";

const ROWS = [
  { key: "address", label: "BD Address", d: "M12 21s-7-6.5-7-12a7 7 0 0 1 14 0c0 5.5-7 12-7 12z M12 9a2 2 0 1 0 .01 0" },
  { key: "phone", label: "Phone", d: "M4 4h5l2 5-3 2a12 12 0 0 0 6 6l2-3 5 2v5a2 2 0 0 1-2 2A16 16 0 0 1 2 6a2 2 0 0 1 2-2" },
  { key: "email", label: "Email", d: "M3 6h18v12H3z M3 7l9 6 9-6" },
];

export function InfoPanel({ heading, highlight, subText, contact = {}, socials = [], mapUrl }) {
  const parts = heading
    ? highlight && heading.includes(highlight)
      ? [heading.split(highlight)[0], highlight, heading.split(highlight)[1]]
      : [heading]
    : [];

  return (
    <div>
      {heading ? (
        <h2 className="text-2xl font-extrabold leading-tight text-heading sm:text-[1.7rem]">
          {parts.map((p, i) => (
            <span key={i} className={p === highlight ? "pfz-text-gradient" : ""}>{p}</span>
          ))}
        </h2>
      ) : null}
      {subText ? <p className="mt-3 text-sm text-muted">{subText}</p> : null}

      <div className="mt-6 space-y-3">
        {ROWS.map((r) => (
          <div
            key={r.key}
            className="flex items-start gap-3 rounded-[var(--pfz-radius-md)] border border-line bg-canvas p-4 shadow-[var(--pfz-shadow-soft)]"
          >
            <span className="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-primary/10 text-primary">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round">
                {r.d.split(" M").map((seg, i) => (
                  <path key={i} d={i === 0 ? seg : "M" + seg} />
                ))}
              </svg>
            </span>
            <div className="min-w-0">
              <p className="text-sm font-bold text-heading">{r.label}</p>
              <p className="break-words text-xs text-muted">{contact[r.key] || "—"}</p>
            </div>
          </div>
        ))}
      </div>

      {socials.length ? (
        <div className="mt-6">
          <p className="mb-2 text-sm font-semibold text-heading">Also find us on</p>
          <div className="flex flex-wrap gap-2">
            {socials.map((s) => (
              <a
                key={s.platform}
                href={s.url}
                target="_blank"
                rel="noopener noreferrer"
                aria-label={s.platform}
                className="grid h-9 w-9 place-items-center rounded-md bg-primary text-white transition hover:brightness-110"
              >
                <Icon name={s.icon} size={16} />
              </a>
            ))}
          </div>
        </div>
      ) : null}

      {mapUrl ? (
        <div className="mt-6 overflow-hidden rounded-[var(--pfz-radius-md)] border border-line">
          <iframe
            src={mapUrl}
            title="Location map"
            className="h-56 w-full"
            loading="lazy"
            referrerPolicy="no-referrer-when-downgrade"
          />
        </div>
      ) : null}
    </div>
  );
}
