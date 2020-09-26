module.exports = {
  env: {
    amd: true,
    browser: true,
    es6: true,
  },
  extends: ['eslint:recommended', 'plugin:vue/recommended'],
  parserOptions: {
    sourceType: 'module',
  },
  rules: {
    indent: ['error', 2],
    quotes: ['warn', 'single'],
    semi: ['warn', 'never'],
    'comma-dangle': [
      'error',
      {
        arrays: 'always-multiline',
        objects: 'always-multiline',
        imports: 'always-multiline',
        exports: 'always-multiline',
        functions: 'never',
      },
    ],
    'vue/max-attributes-per-line': 0,
    'vue/require-default-prop': 0,
    'vue/singleline-html-element-content-newline': 0,
    'vue/html-self-closing': [
      'warn',
      {
        html: {
          void: 'always',
          normal: 'always',
          component: 'always',
        },
        svg: 'always',
        math: 'always',
      },
    ],
  },
}
