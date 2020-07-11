const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  theme: {
    extend: {},
    fill: theme => ({
      current: 'currentColor',
      ...theme('colors'),
    }),
    stroke: theme => ({
      current: 'currentColor',
      ...theme('colors'),
    }),
  },
  variants: [
    'responsive',
    'group-hover',
    'focus-within',
    'hover',
    'focus',
    'active',
    'odd',
    'first',
    'last',
  ],
  purge: {
    content: [
      './resources/**/*.js',
      './resources/**/*.php',
      './resources/**/*.vue',
    ],
  },
  plugins: [require('@tailwindcss/ui')],
}
