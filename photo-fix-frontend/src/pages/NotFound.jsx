import { Link } from "react-router-dom";
import { Helmet } from "react-helmet-async";

export function NotFound() {
  return (
    <>
      <Helmet><title>Page not found</title></Helmet>
      <div className="flex min-h-[70vh] flex-col items-center justify-center gap-4 text-center">
        <p className="pfz-text-gradient text-7xl font-extrabold">404</p>
        <p className="text-lg text-muted">We couldn’t find that page.</p>
        <Link to="/" className="rounded-[var(--pfz-radius-pill)] pfz-gradient-brand px-6 py-3 text-sm font-semibold text-white">
          Back home
        </Link>
      </div>
    </>
  );
}
