import { defineConfig } from "vite";
import react from "@vitejs/plugin-react-swc";
import gzipPlugin from "rollup-plugin-gzip";
import path from "path";

// https://vitejs.dev/config/
export default defineConfig({
  server: {
    port: 7001,
  },
  plugins: [react()],
  build: {
    rollupOptions: {
      plugins: [gzipPlugin()],
    },
  },
  resolve: {
    alias: {
      "@": path.resolve("./src"),
    },
  },
});
