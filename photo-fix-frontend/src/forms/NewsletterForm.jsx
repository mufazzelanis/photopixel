import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { z } from "zod";
import toast from "react-hot-toast";
import { submitSubscribe } from "../api/endpoints";
import { parseApiError } from "../api/client";

const schema = z.object({
  email: z.string().email("Enter a valid email"),
  website: z.string().optional(),
});

export function NewsletterForm({ placeholder = "Email Us", buttonLabel = "Subscribe" }) {
  const {
    register,
    handleSubmit,
    reset,
    formState: { errors, isSubmitting },
  } = useForm({ resolver: zodResolver(schema) });

  const onSubmit = async (values) => {
    try {
      const res = await submitSubscribe(values);
      toast.success(res.data.message);
      reset();
    } catch (e) {
      toast.error(parseApiError(e).message);
    }
  };

  return (
    <form onSubmit={handleSubmit(onSubmit)} className="relative">
      <div className="absolute left-[-9999px]" aria-hidden="true">
        <input tabIndex={-1} autoComplete="off" {...register("website")} />
      </div>
      <input
        type="email"
        placeholder={placeholder}
        className="w-full rounded-[var(--pfz-radius-md)] border border-white/15 bg-white/10 px-4 py-3 text-sm text-white placeholder-white/50 outline-none focus:border-white/40"
        {...register("email")}
      />
      {errors.email ? (
        <span className="mt-1 block text-xs text-red-300">{errors.email.message}</span>
      ) : null}
      <button
        type="submit"
        disabled={isSubmitting}
        className="mt-3 w-full rounded-[var(--pfz-radius-md)] bg-secondary px-4 py-3 text-sm font-semibold text-white transition hover:brightness-110 disabled:opacity-60"
      >
        {isSubmitting ? "…" : buttonLabel}
      </button>
    </form>
  );
}
