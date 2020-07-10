let cssImport = require('postcss-import')
let cssNesting = require('postcss-nesting')
let mix = require('laravel-mix')
let path = require('path')
let tailwindcss = require('tailwindcss')

mix
  .js('resources/js/app.js', 'public/js')
  .postCss('resources/css/app.css', 'public/css', [
    cssImport(),
    cssNesting(),
    tailwindcss('tailwind.config.js'),
  ])
  .webpackConfig({
    resolve: {
      alias: {
        vue$: 'vue/dist/vue.esm.js',
        '@': path.resolve('resources/js'),
      },
    },
  })
  .browserSync('matsusushi.test')

if (mix.inProduction()) {
  mix.version()
}
