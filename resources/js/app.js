import Vue from 'vue'
import vClickOutside from 'v-click-outside'
import './bootstrap'

Vue.config.productionTip = false

Vue.use(vClickOutside)

window.events = new Vue()

Vue.prototype.csrfToken = window.App.csrfToken

window.flash = function(message, level = 'success', ttl = 5) {
  window.events.$emit('flash', {
    message: message,
    level: level,
    ttl: ttl,
  })
}

const files = require.context('./components', true, /\.vue$/i)
files.keys().map(key =>
  Vue.component(
    key
      .split('/')
      .pop()
      .split('.')[0],
    files(key).default
  )
)

const shared = require.context('./Shared', true, /\.vue$/i)
shared.keys().map(key =>
  Vue.component(
    key
      .split('/')
      .pop()
      .split('.')[0],
    shared(key).default
  )
)

const app = new Vue({
  el: '#app',
})
