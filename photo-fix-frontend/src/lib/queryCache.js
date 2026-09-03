/**
 * Tiny stale-while-revalidate cache shared across the app.
 * Once a payload is fetched (or prefetched), navigating back to that page
 * renders instantly from memory while a fresh copy loads in the background.
 */

const store = new Map(); // key -> data
const inflight = new Map(); // key -> Promise
const listeners = new Set(); // pending-count subscribers

let pending = 0;

function notify() {
  for (const fn of listeners) fn(pending);
}

export function onPending(fn) {
  listeners.add(fn);
  fn(pending);
  return () => listeners.delete(fn);
}

export function getCached(key) {
  return store.get(key);
}

export function setCached(key, data) {
  store.set(key, data);
}

/** De-duped fetch. Resolves from cache-updating promise; never throws for prefetch callers that ignore it. */
export function fetchQuery(key, fn) {
  if (inflight.has(key)) return inflight.get(key);

  pending += 1;
  notify();

  const p = Promise.resolve()
    .then(fn)
    .then((data) => {
      store.set(key, data);
      return data;
    })
    .finally(() => {
      inflight.delete(key);
      pending = Math.max(0, pending - 1);
      notify();
    });

  inflight.set(key, p);
  return p;
}

/** Fire-and-forget: warm the cache without caring about the result. */
export function prefetchQuery(key, fn) {
  if (store.has(key) || inflight.has(key)) return;
  fetchQuery(key, fn).catch(() => {});
}
