import axios from "axios";

export const API_URL =
  import.meta.env.VITE_API_URL ?? "http://localhost:8000/api/v1";

export const api = axios.create({
  baseURL: API_URL,
  headers: { Accept: "application/json" },
  timeout: 15000,
});

/** Normalise an axios error into a friendly message + field errors. */
export function parseApiError(error) {
  const res = error?.response;
  if (res?.status === 422) {
    return {
      message: res.data?.message ?? "Please check the form and try again.",
      errors: res.data?.errors ?? {},
    };
  }
  if (res?.status === 429) {
    return { message: "Too many attempts. Please wait a minute and retry.", errors: {} };
  }
  return {
    message: res?.data?.message ?? "Something went wrong. Please try again.",
    errors: {},
  };
}
