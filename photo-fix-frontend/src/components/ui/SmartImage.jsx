import { cn } from "../../lib/utils";

/** Image with a token-tinted placeholder while empty / on error. */
export function SmartImage({ src, alt = "", className, wrapperClassName, ...rest }) {
  const fallback =
    "data:image/svg+xml;utf8," +
    encodeURIComponent(
      `<svg xmlns='http://www.w3.org/2000/svg' width='600' height='400'><rect width='100%' height='100%' fill='%23eef0f6'/><path d='M0 300 L200 170 L330 260 L440 150 L600 300 Z' fill='%23d9def0'/><circle cx='470' cy='90' r='34' fill='%23d9def0'/></svg>`,
    );

  return (
    <span className={cn("block overflow-hidden", wrapperClassName)}>
      <img
        src={src || fallback}
        alt={alt}
        loading="lazy"
        onError={(e) => {
          if (e.currentTarget.src !== fallback) e.currentTarget.src = fallback;
        }}
        className={cn("h-full w-full object-cover", className)}
        {...rest}
      />
    </span>
  );
}
