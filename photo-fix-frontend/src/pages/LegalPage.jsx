import { Helmet } from "react-helmet-async";
import { motion, useScroll, useSpring } from "framer-motion";
import { getLegalPage } from "../api/endpoints";
import { useAsync } from "../hooks/useAsync";
import { ErrorState } from "../components/ui/Loader";
import { PageSkeleton } from "../components/ui/Skeleton";
import { CmsButton } from "../components/ui/CmsButton";

/** Thin brand-gradient bar under the header that fills as the whole page
 *  scrolls — the one "advanced" touch that only makes sense on a long
 *  scroll-heavy page like a legal document. Tracks the whole document
 *  (no target ref) so it can never depend on another element's mount timing. */
function ReadingProgress() {
  const { scrollYProgress } = useScroll();
  const width = useSpring(scrollYProgress, { stiffness: 120, damping: 24, mass: 0.3 });

  return (
    <div className="sticky top-0 z-30 h-1 w-full bg-line/60">
      <motion.div className="h-full pfz-gradient-brand" style={{ scaleX: width, transformOrigin: "0% 50%" }} />
    </div>
  );
}

function Hero({ title, sub, btn, image }) {
  if (image) {
    return (
      <section className="relative flex min-h-[280px] items-center justify-center overflow-hidden sm:min-h-[340px]">
        <motion.img
          src={image}
          alt=""
          initial={{ scale: 1.12 }}
          animate={{ scale: 1 }}
          transition={{ duration: 1.4, ease: [0.22, 1, 0.36, 1] }}
          className="absolute inset-0 h-full w-full object-cover"
        />
        <div className="absolute inset-0 bg-heading/60" />
        <div className="pfz-container relative z-10 py-16 text-center sm:py-20">
          <motion.h1
            initial={{ opacity: 0, y: 18 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6, ease: [0.22, 1, 0.36, 1] }}
            className="text-[1.9rem] font-extrabold text-white sm:text-4xl md:text-[3rem]"
          >
            {title}
          </motion.h1>
          {sub ? (
            <motion.p
              initial={{ opacity: 0, y: 14 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6, delay: 0.1, ease: [0.22, 1, 0.36, 1] }}
              className="mx-auto mt-3 max-w-2xl text-white/85"
            >
              {sub}
            </motion.p>
          ) : null}
          {btn ? (
            <motion.div
              initial={{ opacity: 0, y: 14 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6, delay: 0.2, ease: [0.22, 1, 0.36, 1] }}
              className="mt-7"
            >
              <CmsButton link={btn} variant="white" />
            </motion.div>
          ) : null}
        </div>
      </section>
    );
  }

  return (
    <section className="pfz-gradient-hero pfz-animated-gradient">
      <div className="pfz-container py-12 text-center sm:py-16 md:py-20">
        <motion.h1
          initial={{ opacity: 0, y: 18 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6, ease: [0.22, 1, 0.36, 1] }}
          className="text-[1.9rem] font-extrabold text-heading sm:text-4xl md:text-[3rem]"
        >
          {title}
        </motion.h1>
        {sub ? (
          <motion.p
            initial={{ opacity: 0, y: 14 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6, delay: 0.1, ease: [0.22, 1, 0.36, 1] }}
            className="mx-auto mt-3 max-w-2xl text-muted"
          >
            {sub}
          </motion.p>
        ) : null}
        {btn ? (
          <motion.div
            initial={{ opacity: 0, y: 14 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6, delay: 0.2, ease: [0.22, 1, 0.36, 1] }}
            className="mt-7"
          >
            <CmsButton link={btn} />
          </motion.div>
        ) : null}
      </div>
    </section>
  );
}

/** Renders a Privacy Policy / Terms of Service document — same shell for
 *  both, driven entirely by the admin's Legal Pages content. */
export function LegalPage({ slug }) {
  const { data, error, reload } = useAsync(() => getLegalPage(slug), [slug], `legal:${slug}`);

  if (!data) return error ? <ErrorState onRetry={reload} /> : <PageSkeleton />;

  const { seo, title, hero, body } = data;

  return (
    <>
      <Helmet>
        <title>{seo?.title ?? title}</title>
        <meta name="description" content={seo?.description ?? ""} />
      </Helmet>

      <Hero title={hero.heading} sub={hero.sub_text} btn={hero.btn} image={hero.image} />
      <ReadingProgress />

      <section className="pfz-section">
        <div className="pfz-container">
          {/* No scroll-reveal animation here on purpose — for a document this
              long, a "fade in when scrolled into view" trigger is exactly the
              kind of thing that can fail to fire and leave the text stuck
              invisible. It's always shown immediately instead. */}
          <article className="mx-auto max-w-3xl rounded-[var(--pfz-radius-lg)] border border-line bg-canvas p-6 shadow-[var(--pfz-shadow-card)] sm:p-10">
            <div
              className="prose max-w-none text-body [&_h2]:mt-9 [&_h2]:mb-3 [&_h2]:text-xl [&_h2]:font-extrabold [&_h2]:text-heading [&_h2:first-child]:mt-0 [&_h3]:mt-6 [&_h3]:mb-2 [&_h3]:text-lg [&_h3]:font-bold [&_h3]:text-heading [&_p]:mb-4 [&_p]:leading-relaxed [&_a]:text-primary [&_a]:underline [&_a]:decoration-primary/40 [&_a]:underline-offset-2 hover:[&_a]:decoration-primary"
              dangerouslySetInnerHTML={{ __html: body }}
            />
          </article>
        </div>
      </section>
    </>
  );
}
