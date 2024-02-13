import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import { VitePWA } from 'vite-plugin-pwa'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    VitePWA({
      registerType: 'autoUpdate',
      injectRegister: 'auto',
      includeAssets: ['leaflet.png'],
      manifest: {
        name: 'Leaflet RSGS',
        short_name: 'LeafletRSGS',
        description: 'E-Leaflet RS Graha Sehat',
        theme_color: '#0fb9b1',
        icons: [
          {
            src: './img/leaflet.png',
            sizes: '192x192',
            type: 'image/png'
          },
          {
            src: './img/leaflet.png',
            sizes: '512x512',
            type: 'image/png'
          }
        ]
      }
    })
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  },
  // server: {
  //   watch: {
  //     // usePolling: true,
  //   }
  // },
})
