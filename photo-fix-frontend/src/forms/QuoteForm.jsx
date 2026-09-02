/* eslint-disable react-hooks/refs -- captchaRef is read inside async submit handlers, not during render */
import { useRef, useState } from "react";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { z } from "zod";
import toast from "react-hot-toast";
import { submitQuote } from "../api/endpoints";
import { parseApiError } from "../api/client";
import { useSite } from "../theme/context";
import { Button } from "../components/ui/Button";
import { Recaptcha, recaptchaRequired } from "../components/ui/Recaptcha";
import { Field, inputClass, Honeypot } from "./Field";

const urlish = z
  .string()
  .trim()
  .optional()
  .refine((v) => !v || /^https?:\/\/.+/i.test(v), "Enter a valid URL (starting with http)");

const schema = z.object({
  name: z.string().trim().min(2, "Please enter your name"),
  email: z.string().trim().email("Enter a valid email"),
  phone: z.string().optional(),
  company: z.string().optional(),
  file_link: urlish,
  budget: z.string().optional(),
  message: z.string().optional(),
  // react-hook-form gives checkbox values as strings — coerce to numbers.
  service_ids: z.array(z.coerce.number()).optional(),
  website: z.string().optional(),
});

export function QuoteForm({ onDone }) {
  const { data } = useSite();
  const services = data?.content?.services ?? [];
  const captchaNeeded = recaptchaRequired(data?.captcha);

  const captchaRef = useRef(null);
  const [captchaToken, setCaptchaToken] = useState("");

  const {
    register,
    handleSubmit,
    reset,
    setError,
    formState: { errors, isSubmitting },
  } = useForm({ resolver: zodResolver(schema), defaultValues: { service_ids: [] } });

  const onSubmit = async (values) => {
    if (captchaNeeded && !captchaToken) {
      toast.error('Please complete the "I\'m not a robot" verification.');
      return;
    }
    try {
      const res = await submitQuote({
        ...values,
        service_ids: (values.service_ids ?? []).map(Number),
        recaptcha_token: captchaToken || undefined,
      });
      toast.success(res.data.message);
      reset();
      captchaRef.current?.reset();
      setCaptchaToken("");
      onDone?.();
    } catch (e) {
      const { message, errors: fieldErrors } = parseApiError(e);
      Object.entries(fieldErrors).forEach(([k, v]) =>
        setError(k, { message: Array.isArray(v) ? v[0] : v }),
      );
      captchaRef.current?.reset();
      setCaptchaToken("");
      toast.error(message);
    }
  };

  const onInvalid = (errs) => {
    const first = Object.values(errs)[0];
    toast.error(first?.message ?? "Please check the highlighted fields.");
  };

  return (
    <form onSubmit={handleSubmit(onSubmit, onInvalid)} className="relative space-y-4">
      <Honeypot register={register} />
      <div className="grid gap-4 sm:grid-cols-2">
        <Field label="Name" error={errors.name?.message}>
          <input className={inputClass} {...register("name")} />
        </Field>
        <Field label="Email" error={errors.email?.message}>
          <input className={inputClass} type="email" {...register("email")} />
        </Field>
        <Field label="Phone" error={errors.phone?.message}>
          <input className={inputClass} {...register("phone")} />
        </Field>
        <Field label="Company" error={errors.company?.message}>
          <input className={inputClass} {...register("company")} />
        </Field>
      </div>

      {services.length ? (
        <Field label="Services you need">
          <div className="flex flex-wrap gap-2">
            {services.map((s, i) => (
              <label
                key={s.slug}
                className="flex cursor-pointer items-center gap-2 rounded-[var(--pfz-radius-pill)] border border-line px-3 py-1.5 text-sm has-[:checked]:border-primary has-[:checked]:bg-primary/10"
              >
                <input type="checkbox" value={i + 1} {...register("service_ids")} className="accent-[var(--pfz-color-primary)]" />
                {s.title}
              </label>
            ))}
          </div>
        </Field>
      ) : null}

      <div className="grid gap-4 sm:grid-cols-2">
        <Field label="File link (Drive / Dropbox / WeTransfer)" error={errors.file_link?.message}>
          <input className={inputClass} placeholder="https://" {...register("file_link")} />
        </Field>
        <Field label="Budget (optional)" error={errors.budget?.message}>
          <input className={inputClass} {...register("budget")} />
        </Field>
      </div>

      <Field label="Project details" error={errors.message?.message}>
        <textarea rows={4} className={inputClass} {...register("message")} />
      </Field>

      <Recaptcha ref={captchaRef} onChange={(t) => setCaptchaToken(t ?? "")} />

      <Button as="button" type="submit" size="lg" disabled={isSubmitting} className="w-full">
        {isSubmitting ? "Sending…" : "Send request"}
      </Button>
    </form>
  );
}
