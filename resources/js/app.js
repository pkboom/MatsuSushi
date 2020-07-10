require('./bootstrap')

import Vue from 'vue'

window.events = new Vue()

window.flash = function(message, level = 'success') {
  window.events.$emit('flash', {
    message: message,
    level: level,
  })
}

import OrderInCart from './OrderInCart'

window.Orders = OrderInCart.getCookie('ordersInCart')

document.getElementById('cart-badge')
  ? (document.getElementById('cart-badge').textContent = Orders.count())
  : null

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

// Vue.component('matsu-menu', require('./components/MatsuMenu.vue'))
// Vue.component('categories', require('./components/Categories.vue'))
// Vue.component('menus', require('./components/Menus.vue'))
// Vue.component('cart', require('./components/Cart.vue'))
// Vue.component('matsu-images', require('./components/MatsuImages.vue'))
// Vue.component('flash', require('./components/Flash.vue'))

const app = new Vue({
  el: '#app',
})
