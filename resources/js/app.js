require('./bootstrap')

import Vue from 'vue'

Vue.config.productionTip = false

window.events = new Vue()

Vue.prototype.csrfToken = window.App.csrfToken

window.flash = function(message, level = 'success') {
  window.events.$emit('flash', {
    message: message,
    level: level,
  })
}

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key =>
  Vue.component(
    key
      .split('/')
      .pop()
      .split('.')[0],
    files(key).default
  )
)

const app = new Vue({
  el: '#app',
})
