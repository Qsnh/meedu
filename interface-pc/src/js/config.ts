export default {
  app_url: import.meta.env.VITE_APP_URL || "",
  disable_vip: (import.meta.env.VITE_DISABLE_VIP || "") === "disable",
};
