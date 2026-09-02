import { Link } from "react-router-dom";

/** Compact gradient banner used at the top of the inner pages. */
export function PageHero({ title, subtitle, crumbs = [] }) {
  return (
    <section className="pfz-gradient-hero pfz-animated-gradient">
      <div className="pfz-container py-12 text-center sm:py-16 md:py-20">
        <nav className="mb-3 flex justify-center gap-1 text-xs text-muted">
          <Link to="/" className="hover:text-primary">Home</Link>
          {crumbs.map((c) => (
            <span key={c.label}>
              <span className="mx-1">/</span>
              {c.to ? <Link to={c.to} className="hover:text-primary">{c.label}</Link> : <span className="text-heading">{c.label}</span>}
            </span>
          ))}
        </nav>
        <h1 className="text-2xl font-extrabold text-heading sm:text-3xl md:text-5xl">{title}</h1>
        {subtitle ? <p className="mx-auto mt-3 max-w-2xl text-muted">{subtitle}</p> : null}
      </div>
    </section>
  );
}
