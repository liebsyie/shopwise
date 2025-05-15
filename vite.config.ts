import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";
import { errorReporter } from "@getmocha/vite-plugins";

export default defineConfig({
  plugins: [
    react(),
    errorReporter({
      appId: "0196a334-9142-7bb6-8082-f48854ca85ae",
      env: "development", // or "production"
      showWatermark: false, // or true
    }),
  ],
  server: {
    allowedHosts: true,
  },
});