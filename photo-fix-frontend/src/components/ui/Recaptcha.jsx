/* eslint-disable react-refresh/only-export-components -- helper co-located with the component by design */
import { forwardRef } from "react";
import ReCAPTCHA from "react-google-recaptcha";
import { useSite } from "../../theme/context";

/**
 * Google reCAPTCHA v2 checkbox, rendered only when the admin has enabled it
 * and supplied a site key (Settings → Security). Otherwise renders nothing and
 * the form falls back to the honeypot alone.
 *
 * Pass `config` explicitly on pages that fetch their own payload (Free Trial);
 * elsewhere it reads `captcha` from the shared site payload.
 */
export const Recaptcha = forwardRef(function Recaptcha({ config, onChange }, ref) {
  const site = useSite();
  const cfg = config ?? site.data?.captcha;

  if (!cfg?.enabled || !cfg?.site_key) return null;

  return (
    <div className="pfz-recaptcha">
      <ReCAPTCHA ref={ref} sitekey={cfg.site_key} onChange={onChange} />
    </div>
  );
});

/** True when the admin turned reCAPTCHA on (so the form must require a token). */
export function recaptchaRequired(config) {
  return Boolean(config?.enabled && config?.site_key);
}
