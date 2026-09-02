import { useRef } from "react";
import { motion, useScroll, useTransform } from "framer-motion";
import { Section } from "../ui/Section";
import { SectionHeading } from "../ui/SectionHeading";
import { Reveal } from "../ui/Reveal";
import { Icon } from "../../lib/Icon";
import { useSite } from "../../theme/context";
import { prefersReducedMotion } from "../../lib/utils";

export function WorkProcess({ meta, content }) {
  const steps = content ?? [];
  const trackRef = useRef(null);
  const { animation } = useSite();
  const motionOn =
    animation.enabled && !(animation.respect_reduced_motion && prefersReducedMotion());

  // Connector line "draws" itself in as the track scrolls into view.
  const { scrollYProgress } = useScroll({
    target: trackRef,
    offset: ["start 88%", "end 60%"],
  });
  const lineGrow = useTransform(scrollYProgress, [0, 1], [0, 1]);

  const gradient = steps.length
    ? `linear-gradient(90deg, ${steps.map((s) => s.accent_color).join(", ")})`
    : undefined;

  return (
    <Section id="process" settings={meta.settings}>
      <SectionHeading heading={meta.heading} highlight={meta.highlight_text} sub={meta.sub_heading} />

      <div ref={trackRef} className="relative">
        {/* connector track — vertical on mobile, horizontal on desktop */}
        <div className="pointer-events-none absolute left-7 top-2 bottom-2 w-[3px] rounded-full bg-line md:left-0 md:right-0 md:top-7 md:bottom-auto md:h-[3px] md:w-auto" />
        <motion.div
          className="pfz-animated-gradient pointer-events-none absolute left-7 top-2 w-[3px] origin-top rounded-full [background-size:100%_200%] md:left-0 md:right-0 md:top-7 md:h-[3px] md:w-auto md:origin-left md:[background-size:200%_100%]"
          style={{
            backgroundImage: gradient,
            bottom: 8,
            scaleY: motionOn ? lineGrow : 1,
            scaleX: 1,
          }}
        />

        <div
          className="relative grid gap-10 md:gap-4"
          style={{ gridTemplateColumns: `repeat(${Math.max(steps.length, 1)}, minmax(0, 1fr))` }}
        >
          {steps.map((step, i) => (
            <Reveal
              key={step.title}
              index={i}
              className="group relative flex items-start gap-4 md:block md:text-center"
            >
              <div className="relative z-10 shrink-0 md:mx-auto">
                <motion.div
                  className="grid h-14 w-14 place-items-center rounded-full text-white shadow-[var(--pfz-shadow-card)] transition-transform duration-300 group-hover:-translate-y-1 group-hover:scale-105"
                  style={{ backgroundColor: step.accent_color }}
                  animate={
                    motionOn
                      ? {
                          boxShadow: [
                            `0 0 0 0 ${step.accent_color}59`,
                            `0 0 0 10px ${step.accent_color}00`,
                            `0 0 0 0 ${step.accent_color}00`,
                          ],
                        }
                      : undefined
                  }
                  transition={
                    motionOn
                      ? { duration: 2, repeat: Infinity, repeatDelay: 2.4, delay: i * 0.3, ease: "easeOut" }
                      : undefined
                  }
                >
                  <Icon name={step.icon} size={24} />
                </motion.div>
                <span
                  className="absolute -right-1 -top-1 grid h-5 w-5 place-items-center rounded-full bg-heading text-[10px] font-bold text-white ring-2 ring-canvas"
                  aria-hidden="true"
                >
                  {step.step_no}
                </span>
              </div>

              <div className="pb-1 md:mt-5 md:px-1">
                <h3 className="font-bold text-heading">{step.title}</h3>
                <p className="mt-1.5 text-sm leading-relaxed text-muted md:mt-2">{step.body}</p>
              </div>
            </Reveal>
          ))}
        </div>
      </div>
    </Section>
  );
}
