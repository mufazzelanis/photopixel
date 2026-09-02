import { Swiper, SwiperSlide } from "swiper/react";
import { Autoplay, Pagination, A11y } from "swiper/modules";
import "swiper/css";
import "swiper/css/pagination";
import { useSite } from "../../theme/context";
import { prefersReducedMotion } from "../../lib/utils";

export function Carousel({ children, slidesPerView = 1, breakpoints, className = "" }) {
  const { animation } = useSite();
  const autoplay =
    animation.carousel_autoplay &&
    !(animation.respect_reduced_motion && prefersReducedMotion());

  return (
    <Swiper
      modules={[Autoplay, Pagination, A11y]}
      spaceBetween={24}
      slidesPerView={slidesPerView}
      breakpoints={breakpoints}
      pagination={{ clickable: true }}
      autoplay={autoplay ? { delay: animation.autoplay_delay ?? 4000, disableOnInteraction: false } : false}
      loop
      className={"pfz-carousel " + className}
    >
      {Array.isArray(children)
        ? children.map((child, i) => <SwiperSlide key={i}>{child}</SwiperSlide>)
        : <SwiperSlide>{children}</SwiperSlide>}
    </Swiper>
  );
}
