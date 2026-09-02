import { useSite } from "../../theme/context";
import { prefersReducedMotion } from "../../lib/utils";
import { Icon } from "../../lib/Icon";
import { cn } from "../../lib/utils";

/**
 * Stand-in for the "person photo" next to the contact form until an admin
 * uploads a real one (Homepage → Section Manager → "Contact — Page
 * Heading" → Image). Built from theme tokens so it always matches the
 * site's colours instead of looking like a broken image.
 */
export function ContactIllustration({ className }) {
  const { animation } = useSite();
  const float = animation.enabled && !(animation.respect_reduced_motion && prefersReducedMotion());

  return (
    <div className={cn("relative aspect-[4/5]", className)}>
      <div className="pfz-gradient-brand pfz-animated-gradient absolute inset-0 rounded-[var(--pfz-radius-lg)] shadow-[var(--pfz-shadow-glow)]" />
      <div className="absolute inset-0 grid place-items-center">
        <span className="grid h-28 w-28 place-items-center rounded-full bg-white/15 text-white ring-1 ring-white/25 sm:h-32 sm:w-32">
          <Icon name="headset" size={52} />
        </span>
      </div>

      <span
        className={cn(
          "absolute left-6 top-8 grid h-11 w-11 place-items-center rounded-full bg-white text-secondary shadow-[var(--pfz-shadow-card)]",
          float && "pfz-float",
        )}
      >
        <Icon name="badge-check" size={20} />
      </span>
      <span
        className={cn(
          "absolute bottom-10 right-6 grid h-12 w-12 place-items-center rounded-full bg-white text-primary shadow-[var(--pfz-shadow-card)]",
          float && "pfz-float",
        )}
        style={float ? { animationDelay: "1s" } : undefined}
      >
        <Icon name="sparkles" size={22} />
      </span>
      <span
        className={cn(
          "absolute right-8 top-1/3 grid h-9 w-9 place-items-center rounded-full bg-white text-star shadow-[var(--pfz-shadow-card)]",
          float && "pfz-float",
        )}
        style={float ? { animationDelay: "2s" } : undefined}
      >
        <Icon name="star" size={17} />
      </span>
    </div>
  );
}
