export function Loader({ label = "Loading" }) {
  return (
    <div className="flex min-h-[60vh] flex-col items-center justify-center gap-4">
      <div className="h-10 w-10 animate-spin rounded-full border-4 border-primary/25 border-t-primary" />
      <p className="text-sm text-muted">{label}…</p>
    </div>
  );
}

export function ErrorState({ onRetry }) {
  return (
    <div className="flex min-h-[60vh] flex-col items-center justify-center gap-4 text-center">
      <p className="text-lg font-semibold text-heading">We couldn’t reach the server.</p>
      <p className="max-w-sm text-sm text-muted">
        Make sure the API is running, then try again.
      </p>
      {onRetry ? (
        <button
          onClick={onRetry}
          className="rounded-[var(--pfz-radius-pill)] bg-primary px-5 py-2.5 text-sm font-semibold text-on-primary"
        >
          Retry
        </button>
      ) : null}
    </div>
  );
}
