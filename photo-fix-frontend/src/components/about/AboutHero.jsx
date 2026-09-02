import { motion } from "framer-motion";
import { useSite } from "../../theme/context";
import { useCmsAction } from "../../forms/ModalProvider";
import { Button } from "../ui/Button";
import { SmartImage } from "../ui/SmartImage";
import { splitHighlight, prefersReducedMotion } from "../../lib/utils";

export function AboutHero({ data }) {
  const { animation } = useSite();
  const resolve = useCmsAction();
  const reduce = animation.respect_reduced_motion && prefersReducedMotion();
  const parts = splitHighlight(data.heading, data.highlight);

  const renderBtn = (btn, variant) => {
    if (!btn?.label) return null;
    const a = resolve(btn.url);
    if (a.type === "action")
      return <Button key={variant} as="button" type="button" onClick={a.run} variant={variant} size="lg">{btn.label}</Button>;
    return <Button key={variant} href={a.to || btn.url} to={a.type === "route" ? a.to : undefined} variant={variant} size="lg">{btn.label}</Button>;
  };

  return (
    <section
      className={
        "pfz-gradient-hero relative overflow-hidden pfz-section " +
        (animation.hero?.animated_gradient && !reduce ? "pfz-animated-gradient" : "")
      }
    >
      <div className="pfz-container grid items-center gap-10 text-center lg:grid-cols-2 lg:gap-12 lg:text-left">
        <div>
          <h1 className="text-[1.9rem] font-extrabold leading-[1.15] text-heading sm:text-4xl md:text-[2.9rem]">
            {parts.map((p, i) => (
              <span key={i} className={p.accent ? "pfz-text-gradient" : ""}>{p.text}</span>
            ))}
          </h1>
          {data.sub_text ? (
            <p className="mx-auto mt-5 max-w-xl text-sm leading-relaxed text-muted sm:text-base lg:mx-0">{data.sub_text}</p>
          ) : null}
          <div className="mt-7 flex flex-wrap justify-center gap-3 sm:gap-4 lg:justify-start">
            {renderBtn(data.primary_btn, "primary")}
            {renderBtn(data.secondary_btn, "outline")}
          </div>
        </div>

        <motion.div
          className="relative"
          initial={reduce ? false : { opacity: 0, scale: 0.92 }}
          animate={{ opacity: 1, scale: 1 }}
          transition={{ duration: 0.6 }}
        >
          <SmartImage
            src={data.image}
            alt={data.heading || "About"}
            wrapperClassName={
              "mx-auto max-w-md rounded-[var(--pfz-radius-lg)] " +
              (animation.hero?.float && !reduce ? "pfz-float" : "")
            }
            className="aspect-[5/4]"
          />
        </motion.div>
      </div>
    </section>
  );
}
