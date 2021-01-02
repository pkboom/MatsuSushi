const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  theme: {
    extend: {
      colors: {
        'matsu-blue': {
          '50': '#f6f9fc',
          '600': '#666ee8',
          '700': '#5469d4',
          '800': '#3c52c2',
        },
      },
      fontFamily: {
        serif: ['Playfair Display', ...defaultTheme.fontFamily.sans],
      },
      spacing: {
        '2px': '2px',
      },
    },
    fill: theme => ({
      current: 'currentColor',
      ...theme('colors'),
    }),
    stroke: theme => ({
      current: 'currentColor',
      ...theme('colors'),
    }),
  },
  variants: ['responsive', 'group-hover', 'hover', 'focus'],
  purge: {
    content: [
      './storage/framework/views/*.php',
      './resources/views/**/*.blade.php',
      './resources/js/**/*.vue',
    ],
  },
  plugins: [require('@tailwindcss/ui')],
}
