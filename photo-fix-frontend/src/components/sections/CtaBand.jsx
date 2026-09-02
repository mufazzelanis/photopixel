import { Reveal } from "../ui/Reveal";
import { CmsButton } from "../ui/CmsButton";

export function CtaBand({ content }) {
  if (!content) return null;
  return (
    <section className="pfz-gradient-cta text-white">
      <div className="pfz-container flex flex-col items-center gap-6 py-14 text-center md:flex-row md:justify-between md:text-left">
        <Reveal>
          <h2 className="text-2xl font-extrabold md:text-3xl">{content.heading}</h2>
          {content.sub_text ? (
            <p className="mt-3 max-w-2xl text-sm text-white/85 md:text-base">{content.sub_text}</p>
          ) : null}
        </Reveal>
        <Reveal index={1}>
          <CmsButton link={content.btn} variant="white" size="lg" />
        </Reveal>
      </div>
    </section>
  );
}
