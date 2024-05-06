import { defineConfig } from "vite";
import react from "@vitejs/plugin-react-swc";
import gzipPlugin from "rollup-plugin-gzip";
import legacy from "@vitejs/plugin-legacy";

// https://vitejs.dev/config/
export default defineConfig({
  server: {
    host: "0.0.0.0",
  },
  plugins: [
    react(),
    legacy({
      targets: ["chrome 52"],
      additionalLegacyPolyfills: ["regenerator-runtime/runtime"],
      renderLegacyChunks: true,
      modernPolyfills: true,
    }),
  ],
  build: {
    rollupOptions: {
      plugins: [gzipPlugin()],
    },
  },
});
