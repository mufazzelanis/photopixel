import { useEffect, useRef, useState } from "react";
import { useInView } from "react-intersection-observer";
import { useSite } from "../../theme/context";
import { prefersReducedMotion } from "../../lib/utils";

/**
 * Count-up number. Self-contained (rAF) so there's no dependency-interop
 * surprise, and it respects the admin's animation.counters toggle.
 */
export function Counter({ value = 0, prefix = "", suffix = "", decimals }) {
  const { animation } = useSite();
  const { ref, inView } = useInView({ triggerOnce: true, threshold: 0.4 });
  const dec = decimals ?? (Number.isInteger(value) ? 0 : 1);

  const animate =
    animation.counters &&
    !(animation.respect_reduced_motion && prefersReducedMotion());

  const [display, setDisplay] = useState(0);
  const rafRef = useRef(0);

  useEffect(() => {
    if (!inView || !animate) return;
    const duration = 2000;
    const start = performance.now();
    const tick = (now) => {
      const t = Math.min((now - start) / duration, 1);
      const eased = 1 - Math.pow(1 - t, 3);
      setDisplay(value * eased);
      if (t < 1) rafRef.current = requestAnimationFrame(tick);
    };
    rafRef.current = requestAnimationFrame(tick);
    return () => cancelAnimationFrame(rafRef.current);
  }, [inView, animate, value]);

  // Non-animated (or not-yet-in-view) counters show the final value directly —
  // no need to route it through state+effect just to display a constant.
  const shown = Number(animate && inView ? display : value).toLocaleString("en-US", {
    minimumFractionDigits: dec,
    maximumFractionDigits: dec,
  });

  return (
    <span ref={ref}>
      {prefix}
      {shown}
      {suffix}
    </span>
  );
}
