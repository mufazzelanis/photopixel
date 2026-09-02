import { lazy, Suspense } from "react";
import { BrowserRouter, Route, Routes } from "react-router-dom";
import { HelmetProvider } from "react-helmet-async";
import { Toaster } from "react-hot-toast";
import { ThemeProvider } from "./theme/ThemeProvider";
import { useSite } from "./theme/context";
import { ModalProvider } from "./forms/ModalProvider";
import { SiteLayout } from "./components/layout/SiteLayout";
import { Loader, ErrorState } from "./components/ui/Loader";
import { ErrorBoundary } from "./components/ui/ErrorBoundary";
import { Home } from "./pages/Home";

// Home is eager (first paint); the rest are split into their own chunks.
const Services = lazy(() => import("./pages/Services").then((m) => ({ default: m.Services })));
const ServiceDetail = lazy(() => import("./pages/ServiceDetail").then((m) => ({ default: m.ServiceDetail })));
const About = lazy(() => import("./pages/About").then((m) => ({ default: m.About })));
const FreeTrial = lazy(() => import("./pages/FreeTrial").then((m) => ({ default: m.FreeTrial })));
const Contact = lazy(() => import("./pages/Contact").then((m) => ({ default: m.Contact })));
const Pricing = lazy(() => import("./pages/Pricing").then((m) => ({ default: m.Pricing })));
const Portfolio = lazy(() => import("./pages/Portfolio").then((m) => ({ default: m.Portfolio })));
const Blog = lazy(() => import("./pages/Blog").then((m) => ({ default: m.Blog })));
const BlogPost = lazy(() => import("./pages/BlogPost").then((m) => ({ default: m.BlogPost })));
const NotFound = lazy(() => import("./pages/NotFound").then((m) => ({ default: m.NotFound })));

function Gate({ children }) {
  const { loading, error } = useSite();
  if (loading) return <Loader label="Warming up" />;
  if (error) return <ErrorState onRetry={() => window.location.reload()} />;
  return children;
}

export default function App() {
  return (
    <HelmetProvider>
      <BrowserRouter>
        <ThemeProvider>
          <ModalProvider>
            <ErrorBoundary>
            <Gate>
              <Suspense fallback={<Loader />}>
                <Routes>
                  <Route element={<SiteLayout />}>
                    <Route index element={<Home />} />
                    <Route path="services" element={<Services />} />
                    <Route path="services/:slug" element={<ServiceDetail />} />
                    <Route path="about" element={<About />} />
                    <Route path="free-trial" element={<FreeTrial />} />
                    <Route path="contact" element={<Contact />} />
                    <Route path="pricing" element={<Pricing />} />
                    <Route path="portfolio" element={<Portfolio />} />
                    <Route path="blog" element={<Blog />} />
                    <Route path="blog/:slug" element={<BlogPost />} />
                    <Route path="*" element={<NotFound />} />
                  </Route>
                </Routes>
              </Suspense>
            </Gate>
            </ErrorBoundary>
            <Toaster position="top-center" toastOptions={{ duration: 4000 }} />
          </ModalProvider>
        </ThemeProvider>
      </BrowserRouter>
    </HelmetProvider>
  );
}
