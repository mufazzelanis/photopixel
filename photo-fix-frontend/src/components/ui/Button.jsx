import { Link } from "react-router-dom";
import { useSite } from "../../theme/context";
import { cn } from "../../lib/utils";

const RADIUS = {
  pill: "rounded-[var(--pfz-radius-pill)]",
  md: "rounded-[var(--pfz-radius-md)]",
  sm: "rounded-[var(--pfz-radius-sm)]",
};

/**
 * variant: primary | outline | ghost | white
 * Honors the admin's button style/radius/hover tokens for the primary variant.
 */
export function Button({
  as,
  to,
  href,
  variant = "primary",
  size = "md",
  className,
  children,
  icon = true,
  ...rest
}) {
  const { button } = useSite();
  const radius = RADIUS[button.radius] ?? RADIUS.pill;
  const hover =
    button.hover === "glow"
      ? "hover:shadow-[var(--pfz-shadow-glow)]"
      : button.hover === "lift"
        ? "hover:-translate-y-0.5 hover:shadow-[var(--pfz-shadow-card)]"
        : "";

  const base = cn(
    "inline-flex items-center justify-center gap-2 font-semibold transition-all duration-200 whitespace-nowrap",
    size === "lg" ? "px-7 py-3.5 text-base" : size === "sm" ? "px-4 py-2 text-sm" : "px-6 py-3 text-sm",
    radius,
  );

  const styles = {
    primary: cn(
      button.style === "outline"
        ? "border-2 border-primary text-primary hover:bg-primary hover:text-on-primary"
        : button.style === "solid"
          ? "bg-primary text-on-primary hover:bg-primary-600"
          : "pfz-gradient-brand text-white",
      hover,
    ),
    outline: "border-2 border-current text-heading hover:bg-heading hover:text-white",
    ghost: "text-primary hover:bg-primary/10",
    white: "bg-white text-primary hover:bg-white/90 " + hover,
    cta: "pfz-gradient-cta text-white " + hover,
  };

  const content = (
    <>
      {children}
      {icon ? (
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round" aria-hidden="true">
          <path d="M5 12h14M13 6l6 6-6 6" />
        </svg>
      ) : null}
    </>
  );

  const cls = cn(base, styles[variant] ?? styles.primary, className);

  if (to) return <Link to={to} className={cls} {...rest}>{content}</Link>;
  if (href) return <a href={href} className={cls} {...rest}>{content}</a>;
  const Tag = as ?? "button";
  return <Tag className={cls} {...rest}>{content}</Tag>;
}
