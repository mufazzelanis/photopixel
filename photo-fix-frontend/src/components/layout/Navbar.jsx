import { useEffect, useState } from "react";
import { Link, NavLink, useLocation } from "react-router-dom";
import { AnimatePresence, motion } from "framer-motion";
import { useSite } from "../../theme/context";
import { useCmsAction } from "../../forms/ModalProvider";
import { Button } from "../ui/Button";
import { cn } from "../../lib/utils";

function TopLink({ item, onNavigate }) {
  const [open, setOpen] = useState(false);
  const hasChildren = item.children?.length > 0;

  if (!hasChildren) {
    const isRoute = item.url?.startsWith("/");
    const Cmp = isRoute ? NavLink : "a";
    return (
      <Cmp
        to={isRoute ? item.url : undefined}
        href={isRoute ? undefined : item.url}
        onClick={onNavigate}
        className={({ isActive } = {}) =>
          cn(
            "px-3 py-2 text-sm font-medium text-heading/80 transition hover:text-primary",
            isActive && "text-primary",
          )
        }
      >
        {item.label}
      </Cmp>
    );
  }

  return (
    <div
      className="relative"
      onMouseEnter={() => setOpen(true)}
      onMouseLeave={() => setOpen(false)}
    >
      <button className="flex items-center gap-1 px-3 py-2 text-sm font-medium text-heading/80 transition hover:text-primary">
        {item.label}
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round"><path d="M6 9l6 6 6-6" /></svg>
      </button>
      <AnimatePresence>
        {open && (
          <motion.div
            initial={{ opacity: 0, y: 8 }}
            animate={{ opacity: 1, y: 0 }}
            exit={{ opacity: 0, y: 8 }}
            transition={{ duration: 0.16 }}
            className="absolute left-0 top-full z-50 min-w-[220px] rounded-[var(--pfz-radius-md)] border border-line bg-canvas p-2 shadow-[var(--pfz-shadow-card)]"
          >
            {item.children.map((c) => (
              <Link
                key={c.label}
                to={c.url}
                onClick={onNavigate}
                className="block rounded-[var(--pfz-radius-sm)] px-3 py-2 text-sm text-body transition hover:bg-alt hover:text-primary"
              >
                {c.label}
              </Link>
            ))}
          </motion.div>
        )}
      </AnimatePresence>
    </div>
  );
}

export function Navbar() {
  const { data } = useSite();
  const raw = data?.navigation ?? {};
  const nav = {
    brand: raw.brand ?? "Photo Fix Zone",
    cta: raw.cta ?? {},
    items: Array.isArray(raw.items) ? raw.items : [],
  };
  const resolve = useCmsAction();
  const [scrolled, setScrolled] = useState(false);
  const [mobileOpen, setMobileOpen] = useState(false);
  const location = useLocation();

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 12);
    onScroll();
    window.addEventListener("scroll", onScroll, { passive: true });
    return () => window.removeEventListener("scroll", onScroll);
  }, []);

  useEffect(() => {
    setMobileOpen(false);
  }, [location.pathname]);

  const cta = resolve(nav.cta?.url ?? "#quote");

  return (
    <header
      className={cn(
        "sticky top-0 z-50 transition-all duration-300",
        scrolled ? "bg-canvas/90 py-2 shadow-[var(--pfz-shadow-soft)] backdrop-blur" : "bg-transparent py-4",
      )}
    >
      <div className="pfz-container flex items-center justify-between gap-4">
        <Link to="/" className="flex items-center gap-2 text-lg font-extrabold text-heading">
          <span className="grid h-9 w-9 place-items-center rounded-[var(--pfz-radius-sm)] pfz-gradient-brand text-white">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2"><rect x="3" y="5" width="18" height="14" rx="3" /><circle cx="12" cy="12" r="3.2" /></svg>
          </span>
          <span className="pfz-text-gradient">{nav.brand}</span>
        </Link>

        <nav className="hidden items-center lg:flex">
          {nav.items.filter((i) => !i.is_button).map((item) => (
            <TopLink key={item.label} item={item} />
          ))}
        </nav>

        <div className="hidden lg:block">
          {cta.type === "action" ? (
            <Button as="button" type="button" onClick={cta.run} icon={false}>
              {nav.cta?.label ?? "GET A QUOTE"}
            </Button>
          ) : (
            <Button href={nav.cta?.url ?? "#quote"} icon={false}>
              {nav.cta?.label ?? "GET A QUOTE"}
            </Button>
          )}
        </div>

        <button
          className="lg:hidden rounded-md p-2 text-heading"
          onClick={() => setMobileOpen((v) => !v)}
          aria-label="Toggle menu"
        >
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.2" strokeLinecap="round">
            {mobileOpen ? <path d="M6 6l12 12M18 6L6 18" /> : <path d="M4 7h16M4 12h16M4 17h16" />}
          </svg>
        </button>
      </div>

      <AnimatePresence>
        {mobileOpen && (
          <motion.div
            initial={{ opacity: 0, height: 0 }}
            animate={{ opacity: 1, height: "auto" }}
            exit={{ opacity: 0, height: 0 }}
            className="lg:hidden overflow-hidden border-t border-line bg-canvas"
          >
            <div className="pfz-container flex flex-col gap-1 py-4">
              {nav.items.filter((i) => !i.is_button).map((item) => (
                <div key={item.label}>
                  {item.url?.startsWith("/") ? (
                    <Link to={item.url} className="block py-2 font-medium text-heading">{item.label}</Link>
                  ) : (
                    <a href={item.url} className="block py-2 font-medium text-heading">{item.label}</a>
                  )}
                  {item.children?.length ? (
                    <div className="ml-3 border-l border-line pl-3">
                      {item.children.map((c) => (
                        <Link key={c.label} to={c.url} className="block py-1.5 text-sm text-muted">{c.label}</Link>
                      ))}
                    </div>
                  ) : null}
                </div>
              ))}
              {cta.type === "action" ? (
                <Button as="button" type="button" onClick={cta.run} className="mt-3" icon={false}>
                  {nav.cta?.label ?? "GET A QUOTE"}
                </Button>
              ) : (
                <Button href={nav.cta?.url ?? "#quote"} className="mt-3" icon={false}>
                  {nav.cta?.label ?? "GET A QUOTE"}
                </Button>
              )}
            </div>
          </motion.div>
        )}
      </AnimatePresence>
    </header>
  );
}
