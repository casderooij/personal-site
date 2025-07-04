import browserslist from 'browserslist'
import laravel from 'laravel-vite-plugin'
import { browserslistToTargets } from 'lightningcss'
import { defineConfig } from 'vite'

export default defineConfig({
  css: {
    transformer: 'lightningcss',
    lightningcss: {
      targets: browserslistToTargets(browserslist('>= 0.25%')),
      drafts: {
        customMedia: true,
      },
    },
  },
  plugins: [
    laravel({
      input: ['assets/style.css', 'assets/index.ts'],
      refresh: ['site/templates/**', 'site/snippets/**'],
      publicDirectory: './',
    }),
  ],
  build: {
    cssMinify: 'lightningcss',
  },
})
