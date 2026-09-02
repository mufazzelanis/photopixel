/* eslint-disable react-hooks/refs -- captchaRef is read inside async submit handlers, not during render */
import { useRef, useState } from "react";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { z } from "zod";
import toast from "react-hot-toast";
import { submitFreeTrial } from "../api/endpoints";
import { parseApiError } from "../api/client";
import { useSite } from "../theme/context";
import { Button } from "../components/ui/Button";
import { Recaptcha, recaptchaRequired } from "../components/ui/Recaptcha";
import { Field, inputClass, Honeypot } from "./Field";

const schema = z.object({
  name: z.string().trim().min(2, "Please enter your name"),
  email: z.string().trim().email("Enter a valid email"),
  file_link: z
    .string()
    .trim()
    .optional()
    .refine((v) => !v || /^https?:\/\/.+/i.test(v), "Enter a valid URL (starting with http)"),
  num_images: z.string().optional(),
  requirements: z.string().optional(),
  website: z.string().optional(),
});

export function FreeTrialForm({ onDone }) {
  const { data } = useSite();
  const captchaNeeded = recaptchaRequired(data?.captcha);
  const captchaRef = useRef(null);
  const [captchaToken, setCaptchaToken] = useState("");

  const {
    register,
    handleSubmit,
    reset,
    setError,
    formState: { errors, isSubmitting },
  } = useForm({ resolver: zodResolver(schema) });

  const onSubmit = async (values) => {
    if (captchaNeeded && !captchaToken) {
      toast.error('Please complete the "I\'m not a robot" verification.');
      return;
    }
    try {
      const res = await submitFreeTrial({ ...values, recaptcha_token: captchaToken || undefined });
      toast.success(res.data.message);
      reset();
      captchaRef.current?.reset();
      setCaptchaToken("");
      onDone?.();
    } catch (e) {
      const { message, errors: fe } = parseApiError(e);
      Object.entries(fe).forEach(([k, v]) => setError(k, { message: Array.isArray(v) ? v[0] : v }));
      captchaRef.current?.reset();
      setCaptchaToken("");
      toast.error(message);
    }
  };

  const onInvalid = (errs) =>
    toast.error(Object.values(errs)[0]?.message ?? "Please check the highlighted fields.");

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
        <Field label="File link" error={errors.file_link?.message}>
          <input className={inputClass} placeholder="https://" {...register("file_link")} />
        </Field>
        <Field label="How many images?" error={errors.num_images?.message}>
          <input className={inputClass} {...register("num_images")} />
        </Field>
      </div>
      <Field label="What do you need done?" error={errors.requirements?.message}>
        <textarea rows={4} className={inputClass} {...register("requirements")} />
      </Field>

      <Recaptcha ref={captchaRef} onChange={(t) => setCaptchaToken(t ?? "")} />

      <Button as="button" type="submit" size="lg" disabled={isSubmitting} className="w-full">
        {isSubmitting ? "Sending…" : "Request 5 free trials"}
      </Button>
    </form>
  );
}
