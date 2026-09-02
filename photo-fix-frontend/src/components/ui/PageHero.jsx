/** Compact gradient banner used at the top of the inner pages. */
export function PageHero({ title, subtitle }) {
  return (
    <section className="pfz-gradient-hero pfz-animated-gradient">
      <div className="pfz-container py-12 text-center sm:py-16 md:py-20">
        <h1 className="text-2xl font-extrabold text-heading sm:text-3xl md:text-5xl">{title}</h1>
        {subtitle ? <p className="mx-auto mt-3 max-w-2xl text-muted">{subtitle}</p> : null}
      </div>
    </section>
  );
}
