import { useEffect, useState } from "react";
import { Link, NavLink, useLocation } from "react-router-dom";
import { AnimatePresence, motion } from "framer-motion";
import { useSite } from "../../theme/context";
import { useCmsAction } from "../../forms/ModalProvider";
import { Button } from "../ui/Button";
import { Icon } from "../../lib/Icon";
import { cn } from "../../lib/utils";

// Past this many children a single-column dropdown gets unreasonably tall,
// so it switches to a full-width mega-menu instead (e.g. "Image Editing").
const MEGA_MENU_THRESHOLD = 6;

/** Desktop nav item. Mega items (many children) don't render their own
 *  dropdown — they just report hover up to <Navbar>, which owns the one
 *  shared full-width panel (see there for why). Small dropdowns (few
 *  children) still render their own compact anchored box. */
function TopLink({ item, isMegaOpen, onMegaEnter }) {
  const [open, setOpen] = useState(false);
  const hasChildren = item.children?.length > 0;
  const isMega = (item.children?.length ?? 0) > MEGA_MENU_THRESHOLD;

  if (!hasChildren) {
    const isRoute = item.url?.startsWith("/");
    const Cmp = isRoute ? NavLink : "a";
    return (
      <Cmp
        to={isRoute ? item.url : undefined}
        href={isRoute ? undefined : item.url}
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

  if (isMega) {
    return (
      <button
        onMouseEnter={onMegaEnter}
        className={cn(
          "flex items-center gap-1 px-3 py-2 text-sm font-medium transition",
          isMegaOpen ? "text-primary" : "text-heading/80 hover:text-primary",
        )}
      >
        {item.label}
        <svg
          width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round"
          className={cn("transition-transform duration-200", isMegaOpen && "rotate-180")}
        >
          <path d="M6 9l6 6 6-6" />
        </svg>
      </button>
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

/** Mobile accordion row: children stay collapsed until tapped, so a 17-item
 *  mega-menu (or an 11-item Portfolio list) doesn't push "GET A QUOTE" a full
 *  screen-height away. Expanded children lay out as a compact icon grid. */
function MobileTopLink({ item, onNavigate }) {
  const [expanded, setExpanded] = useState(false);
  const hasChildren = item.children?.length > 0;

  if (!hasChildren) {
    const isRoute = item.url?.startsWith("/");
    const Cmp = isRoute ? Link : "a";
    return (
      <Cmp
        to={isRoute ? item.url : undefined}
        href={isRoute ? undefined : item.url}
        onClick={onNavigate}
        className="block rounded-[var(--pfz-radius-sm)] px-2 py-3 font-medium text-heading transition hover:bg-alt"
      >
        {item.label}
      </Cmp>
    );
  }

  return (
    <div className="border-b border-line/70 last:border-b-0">
      <button
        type="button"
        onClick={() => setExpanded((v) => !v)}
        aria-expanded={expanded}
        className="flex w-full items-center justify-between rounded-[var(--pfz-radius-sm)] px-2 py-3 text-left font-medium text-heading transition hover:bg-alt"
      >
        {item.label}
        <svg
          width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round"
          className={cn("shrink-0 transition-transform duration-200", expanded && "rotate-180")}
        >
          <path d="M6 9l6 6 6-6" />
        </svg>
      </button>
      <AnimatePresence initial={false}>
        {expanded && (
          <motion.div
            initial={{ height: 0, opacity: 0 }}
            animate={{ height: "auto", opacity: 1 }}
            exit={{ height: 0, opacity: 0 }}
            transition={{ duration: 0.2, ease: "easeInOut" }}
            className="overflow-hidden"
          >
            <div className="grid grid-cols-2 gap-1 pb-3 pl-1 pt-1">
              {item.children.map((c) => (
                <Link
                  key={c.label}
                  to={c.url}
                  onClick={onNavigate}
                  className="flex items-center gap-2 rounded-[var(--pfz-radius-sm)] px-2 py-2 text-sm text-muted transition hover:bg-alt hover:text-primary"
                >
                  {c.icon ? (
                    <span className="grid h-6 w-6 shrink-0 place-items-center rounded-md bg-primary/10 text-primary">
                      <Icon name={c.icon} size={13} />
                    </span>
                  ) : null}
                  <span className="truncate">{c.label}</span>
                </Link>
              ))}
            </div>
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
  const [megaItem, setMegaItem] = useState(null);
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
      onMouseLeave={() => setMegaItem(null)}
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
            <TopLink
              key={item.label}
              item={item}
              isMegaOpen={megaItem?.label === item.label}
              onMegaEnter={() => setMegaItem(item)}
            />
          ))}
        </nav>

        <div className="hidden lg:block">
          {cta.type === "action" ? (
            <Button as="button" type="button" onClick={cta.run} icon={false}>
              {nav.cta?.label ?? "GET A QUOTE"}
            </Button>
          ) : cta.type === "route" ? (
            <Button to={cta.to} icon={false}>
              {nav.cta?.label ?? "GET A QUOTE"}
            </Button>
          ) : (
            <Button href={cta.to ?? nav.cta?.url ?? "#quote"} icon={false}>
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

      {/* Shared mega-menu panel. Positioned relative to <header> (not the
          trigger button) so it sits flush under the navbar whatever its
          current height (scrolled vs not) — but the visible card itself is
          wrapped in the same pfz-container as the rest of the site, so it
          lines up with the logo/menu/button instead of bleeding edge to
          edge across the whole browser window. */}
      <AnimatePresence>
        {megaItem && (
          <motion.div
            initial={{ opacity: 0, y: 8 }}
            animate={{ opacity: 1, y: 0 }}
            exit={{ opacity: 0, y: 8 }}
            transition={{ duration: 0.18 }}
            className="absolute left-0 right-0 top-full z-50 hidden lg:block"
          >
            <div className="pfz-container">
              <div className="rounded-b-[var(--pfz-radius-lg)] border border-t-0 border-line bg-canvas p-8 shadow-[var(--pfz-shadow-card)]">
                <p className="mb-5 text-xs font-semibold uppercase tracking-[0.14em] text-muted">{megaItem.label}</p>
                <div className="grid grid-cols-2 gap-x-6 gap-y-1 md:grid-cols-3 xl:grid-cols-4">
                  {megaItem.children.map((c) => (
                    <Link
                      key={c.label}
                      to={c.url}
                      onClick={() => setMegaItem(null)}
                      className="flex items-center gap-3 rounded-[var(--pfz-radius-sm)] px-3 py-2.5 text-sm text-body transition hover:bg-alt hover:text-primary"
                    >
                      {c.icon ? (
                        <span className="grid h-9 w-9 shrink-0 place-items-center rounded-[var(--pfz-radius-sm)] bg-primary/10 text-primary">
                          <Icon name={c.icon} size={17} />
                        </span>
                      ) : null}
                      <span className="truncate">{c.label}</span>
                    </Link>
                  ))}
                </div>
              </div>
            </div>
          </motion.div>
        )}
      </AnimatePresence>

      <AnimatePresence>
        {mobileOpen && (
          <motion.div
            initial={{ opacity: 0, height: 0 }}
            animate={{ opacity: 1, height: "auto" }}
            exit={{ opacity: 0, height: 0 }}
            className="lg:hidden overflow-hidden border-t border-line bg-canvas"
          >
            <div className="pfz-container flex max-h-[70vh] flex-col overflow-y-auto py-4">
              {nav.items.filter((i) => !i.is_button).map((item) => (
                <MobileTopLink key={item.label} item={item} onNavigate={() => setMobileOpen(false)} />
              ))}
              {cta.type === "action" ? (
                <Button as="button" type="button" onClick={cta.run} className="mt-3" icon={false}>
                  {nav.cta?.label ?? "GET A QUOTE"}
                </Button>
              ) : cta.type === "route" ? (
                <Button to={cta.to} className="mt-3" icon={false}>
                  {nav.cta?.label ?? "GET A QUOTE"}
                </Button>
              ) : (
                <Button href={cta.to ?? nav.cta?.url ?? "#quote"} className="mt-3" icon={false}>
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
