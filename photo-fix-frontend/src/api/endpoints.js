import { api } from "./client";

export const getHome = () => api.get("/home").then((r) => r.data);
export const getTheme = () => api.get("/theme").then((r) => r.data);
export const getServices = () => api.get("/services").then((r) => r.data.data);
export const getService = (slug) =>
  api.get(`/services/${slug}`).then((r) => r.data.data);
export const getBlog = (page = 1) =>
  api.get("/blog", { params: { page } }).then((r) => r.data);
export const getPost = (slug) =>
  api.get(`/blog/${slug}`).then((r) => r.data.data);
export const getPageSeo = (key) =>
  api.get(`/page/${key}/seo`).then((r) => r.data.data);
export const getAbout = () => api.get("/about").then((r) => r.data);
export const getFreeTrialPage = () => api.get("/free-trial").then((r) => r.data);

export const submitQuote = (payload) => api.post("/quote", payload);
export const submitContact = (payload) => api.post("/contact", payload);
export const submitSubscribe = (payload) => api.post("/subscribe", payload);

/** Free trial: modal version (JSON) and full-page version (FormData with files). */
export const submitFreeTrial = (payload) => api.post("/free-trial", payload);
export const submitFreeTrialForm = (formData) =>
  api.post("/free-trial", formData, {
    headers: { "Content-Type": "multipart/form-data" },
  });
