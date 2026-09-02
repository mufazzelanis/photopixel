import { bgClass } from "../../theme/context";
import { cn } from "../../lib/utils";

/**
 * Standard section shell: resolves the admin-chosen background, applies the
 * token-driven vertical padding, and centres content in the container.
 * `settings.padding_y` (if set in the admin) overrides the token padding.
 */
export function Section({ id, settings = {}, className, containerClassName, children }) {
  return (
    <section
      id={id}
      className={cn(bgClass(settings.bg), "pfz-section", className)}
      style={settings.padding_y ? { paddingBlock: settings.padding_y } : undefined}
    >
      <div className={cn("pfz-container", containerClassName)}>{children}</div>
    </section>
  );
}
