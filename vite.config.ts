import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";
import { errorReporter } from "@getmocha/vite-plugins";

export default defineConfig({
  base: "/shopwise/", // <-- This is essential for GitHub Pages!
  plugins: [
    react(),
    errorReporter({
      appId: "0196a334-9142-7bb6-8082-f48854ca85ae",
      env: "production", // Use "production" for deployed site
      showWatermark: false,
    }),
  ],
  server: {
    allowedHosts: true,
  },
});
