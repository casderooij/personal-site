import tailwindcss from '@tailwindcss/vite'
import laravel from 'laravel-vite-plugin'
import { defineConfig } from 'vite'

export default defineConfig({
  plugins: [
    tailwindcss(),
    laravel({
      input: ['assets/css/main.css', 'assets/ts/index.ts'],
      refresh: ['site/templates/**', 'site/snippets/**'],
      publicDirectory: './',
    }),
  ],
})
