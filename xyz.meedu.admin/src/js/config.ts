let url = import.meta.env.VITE_APP_URL || "";

declare const window: any;

if (typeof window.meedu_app_url !== "undefined" && window.meedu_app_url) {
  url = window.meedu_app_url;
}

export default {
  url: url,
};
