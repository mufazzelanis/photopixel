import { useEffect, useState } from "react";
import { onPending } from "../../lib/queryCache";

/**
 * Slim top loading bar — the only "loading" affordance on the site.
 * It appears just under the header while a background fetch is in flight and
 * slides away when done. Content underneath never blanks out.
 */
export function TopProgress() {
  const [active, setActive] = useState(false);

  useEffect(() => {
    let hideTimer;
    return onPending((count) => {
      clearTimeout(hideTimer);
      if (count > 0) {
        setActive(true);
      } else {
        hideTimer = setTimeout(() => setActive(false), 250);
      }
    });
  }, []);

  return (
    <div
      aria-hidden="true"
      className="pointer-events-none fixed inset-x-0 top-0 z-[200] h-[3px] overflow-hidden"
      style={{ opacity: active ? 1 : 0, transition: "opacity .25s" }}
    >
      <div
        className="h-full w-2/5 pfz-gradient-brand"
        style={{
          animation: active ? "pfz-topbar 1s ease-in-out infinite" : "none",
        }}
      />
      <style>{`
        @keyframes pfz-topbar {
          0%   { margin-left: -40%; }
          100% { margin-left: 100%; }
        }
      `}</style>
    </div>
  );
}
