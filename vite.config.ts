import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";
import { errorReporter } from "@getmocha/vite-plugins";

export default defineConfig({
  base: "/shopwise/",
  plugins: [
    react(),
    errorReporter({
      appId: "0196a334-9142-7bb6-8082-f48854ca85ae",
      env: "production",
      showWatermark: false,
    }),
  ],
  server: {
    host: '0.0.0.0',
    port: 5174,      
    strictPort: true,
    allowedHosts: true,
  },
});