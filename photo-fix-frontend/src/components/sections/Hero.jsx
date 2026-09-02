import { motion } from "framer-motion";
import { useSite } from "../../theme/context";
import { useCmsAction } from "../../forms/ModalProvider";
import { Button } from "../ui/Button";
import { SmartImage } from "../ui/SmartImage";
import { splitHighlight, prefersReducedMotion } from "../../lib/utils";

export function Hero({ content }) {
  const { animation } = useSite();
  const resolve = useCmsAction();
  const hero = content;
  const parts = splitHighlight(hero.heading, hero.highlight_text);
  const heroAnim = animation.hero ?? {};
  const reduce = animation.respect_reduced_motion && prefersReducedMotion();

  const collage = hero.collage?.length
    ? hero.collage
    : [{ url: "", alt: "sample" }, { url: "", alt: "sample" }, { url: "", alt: "sample" }];

  const renderBtn = (btn, variant) => {
    if (!btn?.label) return null;
    const a = resolve(btn.url);
    if (a.type === "action")
      return <Button key={variant} as="button" type="button" onClick={a.run} variant={variant} size="lg">{btn.label}</Button>;
    if (a.type === "route")
      return <Button key={variant} to={a.to} variant={variant} size="lg">{btn.label}</Button>;
    return <Button key={variant} href={a.to || btn.url} variant={variant} size="lg">{btn.label}</Button>;
  };

  return (
    <section
      className={
        "pfz-gradient-hero relative overflow-hidden pfz-section " +
        (heroAnim.animated_gradient && !reduce ? "pfz-animated-gradient" : "")
      }
    >
      <div className="pfz-container grid items-center gap-10 text-center lg:grid-cols-2 lg:gap-12 lg:text-left">
        <div>
          {hero.eyebrow ? (
            <p className="mb-4 inline-block rounded-full bg-white/60 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-primary">
              {hero.eyebrow}
            </p>
          ) : null}
          <h1 className="text-[1.9rem] font-extrabold leading-[1.15] text-heading sm:text-4xl md:text-5xl lg:text-[3.4rem]">
            {parts.map((p, i) =>
              heroAnim.heading_stagger && !reduce ? (
                <motion.span
                  key={i}
                  initial={{ opacity: 0, y: 20 }}
                  animate={{ opacity: 1, y: 0 }}
                  transition={{ delay: 0.1 + i * 0.12, duration: 0.5 }}
                  className={p.accent ? "pfz-text-gradient" : ""}
                >
                  {p.text}
                </motion.span>
              ) : (
                <span key={i} className={p.accent ? "pfz-text-gradient" : ""}>{p.text}</span>
              ),
            )}
          </h1>
          {hero.sub_text ? (
            <p className="mx-auto mt-5 max-w-xl text-sm leading-relaxed text-muted sm:text-base md:text-lg lg:mx-0">{hero.sub_text}</p>
          ) : null}
          <div className="mt-7 flex flex-wrap justify-center gap-3 sm:gap-4 lg:justify-start">
            {renderBtn(hero.primary_btn, "primary")}
            {renderBtn(hero.secondary_btn, "outline")}
          </div>
        </div>

        <div className="relative">
          <motion.div
            className="relative mx-auto grid max-w-[17rem] grid-cols-2 gap-3 sm:max-w-md sm:gap-4"
            initial={reduce ? false : { opacity: 0, scale: 0.9 }}
            animate={{ opacity: 1, scale: 1 }}
            transition={{ duration: 0.6 }}
          >
            {collage.slice(0, 4).map((img, i) => (
              <div
                key={i}
                className={
                  "overflow-hidden rounded-[var(--pfz-radius-lg)] bg-white shadow-[var(--pfz-shadow-card)] " +
                  (heroAnim.float && !reduce ? "pfz-float " : "") +
                  (i % 2 ? "mt-8" : "")
                }
                style={heroAnim.float && !reduce ? { animationDelay: `${i * 0.6}s` } : undefined}
              >
                <SmartImage src={img.url || img.thumb} alt={img.alt || ""} className="aspect-square" />
              </div>
            ))}
          </motion.div>
        </div>
      </div>
    </section>
  );
}
