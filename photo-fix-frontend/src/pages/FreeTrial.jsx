import { Helmet } from "react-helmet-async";
import { getFreeTrialPage } from "../api/endpoints";
import { useAsync } from "../hooks/useAsync";
import { Loader, ErrorState } from "../components/ui/Loader";
import { Reveal } from "../components/ui/Reveal";
import { Section } from "../components/ui/Section";
import { Icon } from "../lib/Icon";
import { InfoPanel } from "../components/free-trial/InfoPanel";
import { FreeTrialPageForm } from "../forms/FreeTrialPageForm";
import { splitHighlight } from "../lib/utils";

function UploadBlock({ servers = [] }) {
  const parts = splitHighlight(
    "Upload Files To Our WeTransfer & Dropbox Server",
    "WeTransfer & Dropbox Server",
  );
  return (
    <Section id="upload" settings={{ bg: "bg-alt" }} containerClassName="text-center">
      <Reveal>
        <h2 className="mx-auto max-w-3xl text-2xl font-extrabold text-heading sm:text-3xl md:text-4xl">
          {parts.map((p, i) => (
            <span key={i} className={p.accent ? "text-secondary" : ""}>{p.text}</span>
          ))}
        </h2>
        <p className="mx-auto mt-4 max-w-2xl text-sm text-muted md:text-base">
          We discovered the best platform for sharing large files around the world. So, this is how
          we receive and deliver you pictures.
        </p>
      </Reveal>
      <Reveal index={1} className="mt-8 flex flex-wrap justify-center gap-4">
        {servers.map((u) => (
          <a
            key={u.name}
            href={u.url}
            target="_blank"
            rel="noopener noreferrer"
            className={
              "inline-flex items-center gap-2 rounded-[var(--pfz-radius-pill)] px-6 py-3 text-sm font-semibold transition hover:-translate-y-0.5 " +
              (u.button_style === "outline"
                ? "border-2 border-heading text-heading hover:bg-heading hover:text-white"
                : "pfz-gradient-brand text-white")
            }
          >
            <Icon name={u.icon} size={18} />
            {u.name}
          </a>
        ))}
      </Reveal>
    </Section>
  );
}

export function FreeTrial() {
  const { data, loading, error, reload } = useAsync(getFreeTrialPage, []);

  if (loading) return <Loader label="Loading free trial" />;
  if (error) return <ErrorState onRetry={reload} />;

  return (
    <>
      <Helmet>
        <title>{data.seo?.title}</title>
        <meta name="description" content={data.seo?.description ?? ""} />
        {data.seo?.robots ? <meta name="robots" content={data.seo.robots} /> : null}
      </Helmet>

      <section className="pfz-section">
        <div className="pfz-container grid gap-10 lg:grid-cols-[0.85fr_1.4fr] lg:gap-14">
          <Reveal>
            <InfoPanel
              heading={data.heading}
              highlight={data.highlight}
              subText={data.sub_text}
              contact={data.contact}
              socials={data.socials}
              mapUrl={data.map_embed_url}
            />
          </Reveal>

          <Reveal index={1}>
            <h1 className="mb-6 text-xl font-extrabold text-heading sm:text-2xl">
              {data.form_title || "Photo Editing Free Trial"}
            </h1>
            <FreeTrialPageForm page={data} />
          </Reveal>
        </div>
      </section>

      <UploadBlock servers={data.upload_servers} />
    </>
  );
}
