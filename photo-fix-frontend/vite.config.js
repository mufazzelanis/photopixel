import react from '@vitejs/plugin-react'
import tailwindcss from '@tailwindcss/vite'
import { defineConfig } from 'vite'

const VENDORS = [
  ['vendor-react', ['react-router-dom', 'react-dom', '/react/']],
  ['vendor-motion', ['framer-motion']],
  ['vendor-carousel', ['swiper', 'react-compare-slider', 'react-countup']],
  ['vendor-forms', ['react-hook-form', 'zod', '@hookform/resolvers']],
]

// https://vite.dev/config/
export default defineConfig({
  plugins: [react(), tailwindcss()],
  server: {
    host: '127.0.0.1',
    port: 5173,
    strictPort: false,
  },
  build: {
    rollupOptions: {
      output: {
        manualChunks(id) {
          if (!id.includes('node_modules')) return
          for (const [chunk, matchers] of VENDORS) {
            if (matchers.some((m) => id.includes(m))) return chunk
          }
        },
      },
    },
  },
})
