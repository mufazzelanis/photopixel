import { motion } from "framer-motion";
import { useSite } from "../../theme/context";
import { prefersReducedMotion } from "../../lib/utils";

const OFFSETS = {
  "fade-up": (d) => ({ y: d }),
  fade: () => ({}),
  zoom: () => ({ scale: 0.94 }),
  "slide-left": (d) => ({ x: d }),
  "slide-right": (d) => ({ x: -d }),
};

/**
 * Scroll-into-view reveal. Reads type/duration/distance/stagger/once from the
 * active theme's animation tokens. `index` staggers siblings.
 */
export function Reveal({ children, index = 0, as = "div", className, ...rest }) {
  const { animation } = useSite();
  const cfg = animation.reveal ?? {};
  const disabled =
    !animation.enabled ||
    (animation.respect_reduced_motion && prefersReducedMotion());

  if (disabled) {
    const Tag = as;
    return (
      <Tag className={className} {...rest}>
        {children}
      </Tag>
    );
  }

  const distance = cfg.distance ?? 32;
  const from = (OFFSETS[cfg.type] ?? OFFSETS["fade-up"])(distance);
  const MotionTag = motion[as] ?? motion.div;

  return (
    <MotionTag
      className={className}
      initial={{ opacity: 0, ...from }}
      whileInView={{ opacity: 1, x: 0, y: 0, scale: 1 }}
      viewport={{ once: cfg.once ?? true, amount: 0.2 }}
      transition={{
        duration: cfg.duration ?? 0.6,
        delay: (cfg.stagger ?? 0.08) * index,
        ease: [0.22, 1, 0.36, 1],
      }}
      {...rest}
    >
      {children}
    </MotionTag>
  );
}
