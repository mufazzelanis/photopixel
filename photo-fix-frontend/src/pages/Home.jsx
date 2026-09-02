import { Helmet } from "react-helmet-async";
import { useSite } from "../theme/context";
import { Hero } from "../components/sections/Hero";
import { ValueCards } from "../components/sections/ValueCards";
import { About } from "../components/sections/About";
import { ServingGlobally } from "../components/sections/ServingGlobally";
import { Services } from "../components/sections/Services";
import { CtaBand } from "../components/sections/CtaBand";
import { ClientTypes } from "../components/sections/ClientTypes";
import { WorkProcess } from "../components/sections/WorkProcess";
import { WorkSamples } from "../components/sections/WorkSamples";
import { WhyChoose } from "../components/sections/WhyChoose";
import { Testimonials } from "../components/sections/Testimonials";
import { Stats } from "../components/sections/Stats";
import { UploadServers } from "../components/sections/UploadServers";
import { Faq } from "../components/sections/Faq";
import { BlogTeaser } from "../components/sections/BlogTeaser";

/** section.key -> [Component, contentSelector] */
const REGISTRY = {
  hero: [Hero, (c) => c.hero],
  value_cards: [ValueCards, (c) => c.value_cards],
  about: [About, (c) => c.about],
  serving_globally: [ServingGlobally, (c) => c.countries],
  services: [Services, (c) => c.services],
  cta_perfection: [CtaBand, (c) => c.cta_perfection],
  client_types: [ClientTypes, (c) => c.client_types],
  work_process: [WorkProcess, (c) => c.process_steps],
  work_samples: [WorkSamples, (c) => c.work_samples],
  why_choose: [WhyChoose, (c) => c.why_choose],
  testimonials: [Testimonials, (c) => c.testimonials],
  stats: [Stats, (c) => c.stats],
  upload_servers: [UploadServers, (c) => c.upload_servers],
  faq: [Faq, (c) => c.faqs],
  blog: [BlogTeaser, (c) => c.blog_teasers],
};

export function Home() {
  const { data } = useSite();
  if (!data) return null;

  const { sections, content, seo } = data;

  return (
    <>
      <Helmet>
        <title>{seo?.title}</title>
        <meta name="description" content={seo?.description ?? ""} />
        {seo?.robots ? <meta name="robots" content={seo.robots} /> : null}
      </Helmet>

      {sections.map((meta) => {
        const entry = REGISTRY[meta.key];
        if (!entry) return null;
        const [Cmp, select] = entry;
        return <Cmp key={meta.key} meta={meta} content={select(content)} />;
      })}
    </>
  );
}
