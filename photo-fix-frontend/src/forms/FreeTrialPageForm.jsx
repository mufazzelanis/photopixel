/* eslint-disable react-hooks/refs -- captchaRef is read inside async submit handlers, not during render */
import { useRef, useState } from "react";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { z } from "zod";
import toast from "react-hot-toast";
import { submitFreeTrialForm } from "../api/endpoints";
import { parseApiError } from "../api/client";
import { Button } from "../components/ui/Button";
import { Recaptcha, recaptchaRequired } from "../components/ui/Recaptcha";
import { Field, inputClass, Honeypot } from "./Field";

const schema = z.object({
  name: z.string().trim().min(2, "Please enter your name"),
  email: z.string().trim().email("Enter a valid email"),
  phone: z.string().trim().min(4, "Enter your phone number"),
  country: z.string().trim().min(2, "Enter your country"),
  delivery_timeline: z.string().min(1, "Select a delivery timeline"),
  file_format: z.string().min(1, "Select a file format"),
  services: z.array(z.string()).min(1, "Pick at least one service"),
  file_link: z
    .string()
    .trim()
    .optional()
    .refine((v) => !v || /^https?:\/\/.+/i.test(v), "Enter a valid URL"),
  requirements: z.string().optional(),
  how_found: z.string().min(1, "Let us know how you found us"),
  website: z.string().optional(),
});

export function FreeTrialPageForm({ page }) {
  const opts = page.options ?? {};
  const maxImages = page.max_images ?? 5;
  const limit = page.instructions_limit ?? 180;
  const captchaNeeded = recaptchaRequired(page.captcha);

  const fileRef = useRef(null);
  const captchaRef = useRef(null);
  const [files, setFiles] = useState([]);
  const [dragOver, setDragOver] = useState(false);
  const [captchaToken, setCaptchaToken] = useState("");

  const {
    register,
    handleSubmit,
    reset,
    setError,
    watch,
    formState: { errors, isSubmitting },
  } = useForm({ resolver: zodResolver(schema), defaultValues: { services: [] } });

  const instructions = watch("requirements") ?? "";

  const addFiles = (list) => {
    const incoming = Array.from(list).filter((f) => f.type.startsWith("image/"));
    setFiles((prev) => [...prev, ...incoming].slice(0, maxImages));
  };

  const resetCaptcha = () => {
    captchaRef.current?.reset();
    setCaptchaToken("");
  };

  const onSubmit = async (values) => {
    if (captchaNeeded && !captchaToken) {
      toast.error('Please complete the "I\'m not a robot" verification.');
      return;
    }

    const fd = new FormData();
    Object.entries(values).forEach(([k, v]) => {
      if (k === "services") return;
      if (v != null && v !== "") fd.append(k, v);
    });
    (values.services ?? []).forEach((s) => fd.append("services[]", s));
    files.forEach((f) => fd.append("samples[]", f));
    fd.append("trial_type", "photo");
    if (captchaToken) fd.append("recaptcha_token", captchaToken);

    try {
      const res = await submitFreeTrialForm(fd);
      toast.success(res.data.message);
      reset();
      setFiles([]);
      resetCaptcha();
    } catch (e) {
      const { message, errors: fe } = parseApiError(e);
      Object.entries(fe).forEach(([k, v]) =>
        setError(k.replace(/\.\d+$/, ""), { message: Array.isArray(v) ? v[0] : v }),
      );
      resetCaptcha();
      toast.error(message);
    }
  };

  const onInvalid = (errs) =>
    toast.error(Object.values(errs)[0]?.message ?? "Please check the highlighted fields.");

  return (
    <form onSubmit={handleSubmit(onSubmit, onInvalid)} className="relative space-y-5">
      <Honeypot register={register} />

      <div className="grid gap-4 sm:grid-cols-2">
        <Field label="Name *" error={errors.name?.message}>
          <input className={inputClass} {...register("name")} />
        </Field>
        <Field label="Email Address *" error={errors.email?.message}>
          <input className={inputClass} type="email" {...register("email")} />
        </Field>
        <Field label="Phone Number *" error={errors.phone?.message}>
          <input className={inputClass} placeholder="+1 201-555-0123" {...register("phone")} />
        </Field>
        <Field label="Country *" error={errors.country?.message}>
          <input className={inputClass} {...register("country")} />
        </Field>
        <Field label="Delivery Timeline *" error={errors.delivery_timeline?.message}>
          <select className={inputClass} defaultValue="" {...register("delivery_timeline")}>
            <option value="" disabled>Select</option>
            {(opts.timeline ?? []).map((o) => <option key={o} value={o}>{o}</option>)}
          </select>
        </Field>
        <Field label="Required File Format *" error={errors.file_format?.message}>
          <select className={inputClass} defaultValue="" {...register("file_format")}>
            <option value="" disabled>Select</option>
            {(opts.file_format ?? []).map((o) => <option key={o} value={o}>{o}</option>)}
          </select>
        </Field>
      </div>

      <Field label="Services I am Looking for *" error={errors.services?.message}>
        <div className="grid gap-x-4 gap-y-2 sm:grid-cols-2 lg:grid-cols-3">
          {(opts.service ?? []).map((s) => (
            <label key={s} className="flex items-center gap-2 text-sm text-body">
              <input
                type="checkbox"
                value={s}
                {...register("services")}
                className="h-4 w-4 accent-[var(--pfz-color-primary)]"
              />
              {s}
            </label>
          ))}
        </div>
      </Field>

      <Field label={`Upload your sample images (MAX ${maxImages})`}>
        <div
          onDragOver={(e) => { e.preventDefault(); setDragOver(true); }}
          onDragLeave={() => setDragOver(false)}
          onDrop={(e) => { e.preventDefault(); setDragOver(false); addFiles(e.dataTransfer.files); }}
          onClick={() => fileRef.current?.click()}
          className={
            "flex cursor-pointer flex-col items-center justify-center gap-2 rounded-[var(--pfz-radius-md)] border-2 border-dashed p-6 text-center text-sm transition " +
            (dragOver ? "border-primary bg-primary/5" : "border-line")
          }
        >
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" className="text-primary">
            <path d="M12 15V4M8 8l4-4 4 4M4 15v3a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-3" />
          </svg>
          <span className="text-muted">
            Drag and Drop <span className="font-semibold text-primary">or Choose Files</span>
          </span>
          <input
            ref={fileRef}
            type="file"
            accept="image/*"
            multiple
            hidden
            onChange={(e) => addFiles(e.target.files)}
          />
        </div>
        {files.length ? (
          <ul className="mt-3 space-y-1.5">
            {files.map((f, i) => (
              <li key={i} className="flex items-center justify-between rounded-md bg-alt px-3 py-1.5 text-xs">
                <span className="truncate">{f.name}</span>
                <button
                  type="button"
                  onClick={(e) => { e.stopPropagation(); setFiles((p) => p.filter((_, x) => x !== i)); }}
                  className="ml-3 shrink-0 text-red-600"
                >
                  Remove
                </button>
              </li>
            ))}
          </ul>
        ) : null}
      </Field>

      <Field label="Or insert your Image Link" error={errors.file_link?.message}>
        <input
          className={inputClass}
          placeholder="Dropbox, WeTransfer, Google Drive, OneDrive or any file sharing link"
          {...register("file_link")}
        />
      </Field>

      <Field label="Write down your complete editing instructions" error={errors.requirements?.message}>
        <textarea
          rows={4}
          maxLength={limit}
          className={inputClass}
          {...register("requirements")}
        />
        <span className="mt-1 block text-right text-xs text-muted">
          {instructions.length} / {limit}
        </span>
      </Field>

      <Field label="How did you find us? *" error={errors.how_found?.message}>
        <select className={inputClass} defaultValue="" {...register("how_found")}>
          <option value="" disabled>Select</option>
          {(opts.how_found ?? []).map((o) => <option key={o} value={o}>{o}</option>)}
        </select>
      </Field>

      <Recaptcha ref={captchaRef} config={page.captcha} onChange={(t) => setCaptchaToken(t ?? "")} />

      <Button as="button" type="submit" size="lg" disabled={isSubmitting} className="w-full sm:w-auto">
        {isSubmitting ? "Sending…" : "Send free trial"}
      </Button>
    </form>
  );
}
