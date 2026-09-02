import { Component } from "react";

export class ErrorBoundary extends Component {
  state = { error: null };

  static getDerivedStateFromError(error) {
    return { error };
  }

  componentDidCatch(error, info) {
    console.error("UI crash:", error, info);
  }

  render() {
    if (!this.state.error) return this.props.children;
    return (
      <div className="flex min-h-screen flex-col items-center justify-center gap-4 p-6 text-center">
        <p className="text-lg font-semibold text-heading">Something broke while rendering this page.</p>
        <pre className="max-w-lg overflow-auto rounded-lg bg-alt p-4 text-left text-xs text-muted">
          {String(this.state.error?.message ?? this.state.error)}
        </pre>
        <button
          onClick={() => window.location.reload()}
          className="rounded-full bg-primary px-5 py-2.5 text-sm font-semibold text-on-primary"
        >
          Reload
        </button>
      </div>
    );
  }
}
