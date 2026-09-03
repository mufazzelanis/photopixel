import { prefetchQuery } from "./queryCache";
import { getService, getPost } from "../api/endpoints";

/** Call on hover/focus of a link so the target page is already loaded on click. */
export const prefetchService = (slug) =>
  slug && prefetchQuery(`service:${slug}`, () => getService(slug));

export const prefetchPost = (slug) =>
  slug && prefetchQuery(`post:${slug}`, () => getPost(slug));

/** Spread onto a <Link> that points at a service/blog detail page. */
export const hoverPrefetch = (fn, arg) => ({
  onMouseEnter: () => fn(arg),
  onFocus: () => fn(arg),
  onTouchStart: () => fn(arg),
});
