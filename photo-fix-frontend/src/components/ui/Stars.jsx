export function Stars({ value = 5, className = "" }) {
  return (
    <div className={"flex gap-0.5 " + className} aria-label={`${value} out of 5`}>
      {Array.from({ length: 5 }).map((_, i) => (
        <svg
          key={i}
          width="18"
          height="18"
          viewBox="0 0 24 24"
          fill={i < value ? "var(--pfz-color-star)" : "none"}
          stroke="var(--pfz-color-star)"
          strokeWidth="1.5"
          aria-hidden="true"
        >
          <path d="M12 3l2.9 5.9 6.5.9-4.7 4.6 1.1 6.5L12 18l-5.8 3 1.1-6.5L2.6 9.8l6.5-.9z" />
        </svg>
      ))}
    </div>
  );
}
