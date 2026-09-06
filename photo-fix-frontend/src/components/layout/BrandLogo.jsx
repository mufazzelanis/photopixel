import { useSite } from "../../theme/context";

/**
 * The site logo lockup, shared by the header and footer.
 *
 * - Admin-uploaded image → shown at the admin-set height, optionally wrapped in
 *   a light or dark rounded "chip" so a logo that isn't on a transparent
 *   background still looks deliberate instead of a stray box.
 * - No image → a polished gradient wordmark (icon tile + brand name).
 *
 * variant: "header" (default, light surface) | "footer" (dark surface)
 */
export function BrandLogo({ variant = "header", className = "" }) {
  const { data } = useSite();
  const nav = data?.navigation ?? {};
  const brand = nav.brand ?? "Pixel Graphic Studio";
  const onDark = variant === "footer";

  const img = onDark ? nav.logo_dark || nav.logo : nav.logo || null;
  const bg = nav.logo_bg ?? "none";
  const h = Math.min(Math.max(Number(nav.logo_height) || 36, 20), 72);

  if (img) {
    const chip =
      bg === "light"
        ? "rounded-xl bg-white px-2.5 py-1.5 shadow-sm ring-1 ring-black/5"
        : bg === "dark"
          ? "rounded-xl bg-[#1d1d1f] px-2.5 py-1.5 ring-1 ring-white/10"
          : "";
    return (
      <span className={`inline-flex items-center ${chip} ${className}`}>
        <img
          src={img}
          alt={brand}
          style={{ height: `${onDark ? Math.round(h * 1.08) : h}px` }}
          className="w-auto max-w-[190px] object-contain sm:max-w-[240px]"
        />
      </span>
    );
  }

  // Text lockup
  const tile = onDark ? "bg-accent" : "pfz-gradient-brand";
  const size = onDark ? 40 : 36;
  return (
    <span className={`inline-flex min-w-0 items-center gap-2.5 ${className}`}>
      <span
        className={`grid shrink-0 place-items-center rounded-[10px] text-white ${tile}`}
        style={{ height: size, width: size }}
      >
        <svg width={onDark ? 20 : 18} height={onDark ? 20 : 18} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
          <rect x="3" y="5" width="18" height="14" rx="3" />
          <circle cx="12" cy="12" r="3.2" />
        </svg>
      </span>
      <span
        className={`pfz-text-gradient truncate font-extrabold tracking-tight ${
          onDark ? "text-xl sm:text-2xl" : "text-[1.05rem] sm:text-xl"
        }`}
      >
        {brand}
      </span>
    </span>
  );
}
