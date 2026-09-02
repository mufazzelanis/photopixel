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

/** Hidden honeypot — bots fill it, humans never see it. */
export function Honeypot({ register }) {
  return (
    <div className="absolute left-[-9999px]" aria-hidden="true">
      <input tabIndex={-1} autoComplete="off" {...register("website")} />
    </div>
  );
}
