import { useEffect, useState } from "react";
import { getCached, fetchQuery } from "../lib/queryCache";

/**
 * Data hook with stale-while-revalidate caching.
 *
 *   useAsync(() => getAbout(), [], "about")
 *
 * If `cacheKey` is given and that key is already cached (e.g. prefetched),
 * the hook returns the data on the FIRST render with `loading: false` — so the
 * page paints instantly, then quietly refreshes in the background.
 * Without a key it behaves like a plain one-shot fetch.
 */
export function useAsync(fn, deps = [], cacheKey = null) {
  const seed = cacheKey ? getCached(cacheKey) : undefined;

  const [state, setState] = useState({
    data: seed ?? null,
    loading: seed === undefined,
    error: null,
  });
  const [nonce, setNonce] = useState(0);

  useEffect(() => {
    let alive = true;
    const cached = cacheKey ? getCached(cacheKey) : undefined;

    if (cached !== undefined && nonce === 0) {
      setState({ data: cached, loading: false, error: null });
    } else {
      setState((s) => ({ ...s, loading: s.data == null, error: null }));
    }

    const run = cacheKey && nonce === 0
      ? fetchQuery(cacheKey, fn)
      : Promise.resolve().then(fn);

    run
      .then((data) => {
        if (!alive) return;
        if (cacheKey) getCached(cacheKey); // keep store hot
        setState({ data, loading: false, error: null });
      })
      .catch((error) => {
        if (alive) setState((s) => ({ ...s, loading: s.data == null ? false : s.loading, error }));
      });

    return () => {
      alive = false;
    };
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [...deps, nonce, cacheKey]);

  return { ...state, reload: () => setNonce((n) => n + 1) };
}
