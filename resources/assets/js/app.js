require('./bootstrap');

window.Vue = require('vue');

window.events = new Vue();

window.flash = function (message, level = 'success') {
    window.events.$emit(
        'flash', {
            message: message,
            level: level
        }
    );
};

import OrderInCart from './OrderInCart';

window.Orders = OrderInCart.getCookie('ordersInCart');
document.getElementById("cart-badge") ? document.getElementById("cart-badge").textContent = Orders.count() : null;

Vue.component('matsu-menu', require('./components/MatsuMenu.vue'));
Vue.component('categories', require('./components/Categories.vue'));
Vue.component('menus', require('./components/Menus.vue'));
Vue.component('chat', require('./components/Chat.vue'));
Vue.component('cart', require('./components/Cart.vue'));
Vue.component('admin-chat', require('./components/AdminChat.vue'));
Vue.component('flash', require('./components/Flash.vue'));

const app = new Vue({
    el: '#app'
});

