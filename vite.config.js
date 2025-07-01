import browserslist from 'browserslist'
import laravel from 'laravel-vite-plugin'
import { browserslistToTargets } from 'lightningcss'
import { defineConfig } from 'vite'

export default defineConfig({
  css: {
    transformer: 'lightningcss',
    lightningcss: {
      targets: browserslistToTargets(browserslist('>= 0.25%')),
    },
  },
  plugins: [
    laravel({
      input: ['assets/style.css', 'assets/index.js'],
      refresh: ['site/templates/**', 'site/snippets/**'],
      publicDirectory: './',
    }),
  ],
})
