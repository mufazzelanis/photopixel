import { Helmet } from "react-helmet-async";
import { useSite } from "../theme/context";
import { PageHero } from "../components/ui/PageHero";
import { Services as ServicesSection } from "../components/sections/Services";
import { CtaBand } from "../components/sections/CtaBand";

export function Services() {
  const { data } = useSite();
  if (!data) return null;
  const meta = data.sections.find((s) => s.key === "services") ?? { key: "services", settings: {} };

  return (
    <>
      <Helmet><title>Photo Editing Services — Pixel Graphic Studio</title></Helmet>
      <PageHero title="Our Photo Editing Services" subtitle={meta.sub_heading} crumbs={[{ label: "Services" }]} />
      <ServicesSection meta={{ ...meta, heading: null, sub_heading: null }} content={data.content.services} />
      <CtaBand content={data.content.cta_perfection} />
    </>
  );
}
