import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
  plugins: [
    laravel({
      input: ['assets/style.css', 'assets/index.js'],
      refresh: ['site/templates/**', 'site/snippets/**'],
      publicDirectory: './',
    }),
  ],
})
