import { cn } from "../lib/utils";

export function Field({ label, error, children, className }) {
  return (
    <label className={cn("block", className)}>
      {label ? (
        <span className="mb-1.5 block text-sm font-medium text-heading">{label}</span>
      ) : null}
      {children}
      {error ? <span className="mt-1 block text-xs text-red-600">{error}</span> : null}
    </label>
  );
}

export const inputClass =
  "w-full rounded-[var(--pfz-radius-md)] border border-line bg-canvas px-4 py-2.5 text-sm text-body outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20";

/**
 * Hidden honeypot — bots fill it, humans never see it.
 *
 * Zero-size + `display:none`-equivalent (not just off-screen positioning),
 * and a field name that doesn't match any browser/password-manager autofill
 * category. Chrome, and address/business autofill in particular, will
 * happily fill an off-screen-but-normal-sized field named "website" once a
 * form's surrounding fields (name, phone, company) look like a contact/
 * address form — that filled real users' submissions in as false bot
 * detections. Browsers skip zero-size fields for autofill, but naive bots
 * that blindly fill every `<input>` in the DOM still catch it.
 */
export function Honeypot({ register }) {
  return (
    <div className="absolute h-0 w-0 overflow-hidden opacity-0" aria-hidden="true">
      <input tabIndex={-1} autoComplete="off" {...register("hp_confirm")} />
    </div>
  );
}
