/**
 * Lightweight shimmer placeholder shown only on a cold first fetch of a
 * per-item page (a specific blog post / service). Prefetched pages skip it
 * entirely. Keeps the header/footer in place — the screen never goes blank.
 */
export function PageSkeleton() {
  return (
    <div className="pfz-section">
      <div className="pfz-container max-w-3xl animate-pulse">
        <div className="h-3 w-24 rounded bg-line" />
        <div className="mt-5 h-9 w-4/5 rounded bg-line" />
        <div className="mt-3 h-9 w-2/3 rounded bg-line" />
        <div className="mt-8 aspect-[16/9] w-full rounded-[var(--pfz-radius-lg)] bg-line" />
        <div className="mt-8 space-y-3">
          {Array.from({ length: 5 }).map((_, i) => (
            <div key={i} className="h-4 rounded bg-line" style={{ width: `${90 - i * 8}%` }} />
          ))}
        </div>
      </div>
    </div>
  );
}
