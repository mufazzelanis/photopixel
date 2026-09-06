import { BrowserRouter, Route, Routes, useLocation } from "react-router-dom";
import { HelmetProvider } from "react-helmet-async";
import { Toaster } from "react-hot-toast";
import { ThemeProvider } from "./theme/ThemeProvider";
import { useSite } from "./theme/context";
import { ModalProvider } from "./forms/ModalProvider";
import { SiteLayout } from "./components/layout/SiteLayout";
import { ErrorState } from "./components/ui/Loader";
import { ErrorBoundary } from "./components/ui/ErrorBoundary";
import { TopProgress } from "./components/ui/TopProgress";
import { InstallPrompt } from "./components/pwa/InstallPrompt";
import { Home } from "./pages/Home";
import { Services } from "./pages/Services";
import { ServiceDetail } from "./pages/ServiceDetail";
import { About } from "./pages/About";
import { FreeTrial } from "./pages/FreeTrial";
import { Contact } from "./pages/Contact";
import { Pricing } from "./pages/Pricing";
import { Portfolio } from "./pages/Portfolio";
import { PortfolioCategory } from "./pages/PortfolioCategory";
import { Blog } from "./pages/Blog";
import { BlogPost } from "./pages/BlogPost";
import { LegalPage } from "./pages/LegalPage";
import { NotFound } from "./pages/NotFound";

/**
 * First-visit gate. On a refresh the theme payload is restored synchronously
 * from sessionStorage, so this only shows on a truly cold first load — and
 * even then it's a blank frame, never a spinner.
 */
function Gate({ children }) {
  const { loading, error, data } = useSite();
  if (error && !data) return <ErrorState onRetry={() => window.location.reload()} />;
  if (loading && !data) return <div className="min-h-screen bg-canvas" />;
  return children;
}

/**
 * A crash on one page must never poison every page after it. ErrorBoundary
 * is a class component whose caught-error state has nothing to do with
 * routing, so without this it stays crashed for the rest of the session —
 * every page you click to next shows the same "Something broke" screen
 * even though that page is fine. Keying it by the route remounts (and so
 * resets) it on every navigation.
 */
function RouteScopedErrorBoundary({ children }) {
  const location = useLocation();
  return <ErrorBoundary key={location.pathname}>{children}</ErrorBoundary>;
}

function AppRoutes() {
  return (
    <RouteScopedErrorBoundary>
      <TopProgress />
      <Gate>
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
            <Route path="portfolio/:slug" element={<PortfolioCategory />} />
            <Route path="blog" element={<Blog />} />
            <Route path="blog/:slug" element={<BlogPost />} />
            <Route path="privacy-policy" element={<LegalPage slug="privacy-policy" />} />
            <Route path="terms-of-service" element={<LegalPage slug="terms-of-service" />} />
            <Route path="*" element={<NotFound />} />
          </Route>
        </Routes>
      </Gate>
    </RouteScopedErrorBoundary>
  );
}

export default function App() {
  return (
    <HelmetProvider>
      <BrowserRouter>
        <ThemeProvider>
          <ModalProvider>
            <AppRoutes />
            <InstallPrompt />
            <Toaster position="top-center" toastOptions={{ duration: 4000 }} />
          </ModalProvider>
        </ThemeProvider>
      </BrowserRouter>
    </HelmetProvider>
  );
}
