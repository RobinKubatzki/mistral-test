import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [vue()],
  server: {
    port: 5173,
    host: true,
    strictPort: true
  },
  base: '/',
  resolve: {
    alias: {
      vue: 'vue'
    }
  }
})
