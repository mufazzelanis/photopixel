import { Button } from "./Button";
import { useCmsAction } from "../../forms/ModalProvider";

/**
 * Renders a button/link from a CMS { label, url } pair, wiring up the
 * "#quote" / "#free-trial" modal triggers and "#anchor" smooth-scrolls.
 */
export function CmsButton({ link, label, url, variant = "primary", size = "md", className, icon = true }) {
  const resolve = useCmsAction();
  const l = link?.label ?? label;
  const u = link?.url ?? url;
  if (!l) return null;

  const action = resolve(u);

  if (action.type === "action")
    return (
      <Button as="button" type="button" onClick={action.run} variant={variant} size={size} className={className} icon={icon}>
        {l}
      </Button>
    );
  if (action.type === "external")
    return (
      <Button href={action.to} target="_blank" rel="noopener noreferrer" variant={variant} size={size} className={className} icon={icon}>
        {l}
      </Button>
    );
  if (action.type === "anchor")
    return (
      <Button href={action.to} variant={variant} size={size} className={className} icon={icon}>
        {l}
      </Button>
    );
  if (action.type === "route")
    return (
      <Button to={action.to} variant={variant} size={size} className={className} icon={icon}>
        {l}
      </Button>
    );
  return null;
}
