Vue.component('cart-list', require('./components/cart-list.vue'));
Vue.component('cart-item', require('./components/cart-item.vue'));
Vue.component('cart-total', require('./components/cart-total.vue'));

cartCounter = () => {
	let cookieValue = JSON.parse(getCookie("ordersInCart"));
	// update cart badges
	if (document.getElementById('cart-badge')) {
		cookieValue ? document.getElementById("cart-badge").textContent = cookieValue.length : "";
	}
}

// update cart badges
cartCounter();

if (document.getElementById('app-cart')) {
	const appMenu = new Vue({
		el: '#app-cart',

		data: {
			ordersInCart: '', // used in cart component; list of orders
			subtotalInCart: 0,
		},

		methods: {
			subTotal() {
				// sum order price => subtotal
				this.subtotalInCart = this.ordersInCart
					.map( el => parseFloat(el.price) * parseFloat(el.quantity) )
					.reduce( (acc, cur) => acc + cur, 0 );
				this.subtotalInCart = this.subtotalInCart.toFixed(2);
			},

			onRemoveOrder(count) {
				let cookieValue = JSON.parse(getCookie("ordersInCart"));

				// remove canceled order
				cookieValue.splice(count.count, 1);

	            // update cart badges
	            cookieValue ? document.getElementById("cart-badge").textContent = cookieValue.length : null;
	            this.ordersInCart = cookieValue;

				// save cookie for 60 days
				setCookie("ordersInCart", JSON.stringify(cookieValue), this.oneWeek);

				this.subTotal();
			},

			onQuantityChanged(item) {
				let cookieValue = JSON.parse(getCookie("ordersInCart"));

				cookieValue[item.count].quantity = item.quantity;

	            // update cart
	            this.ordersInCart = cookieValue;

				// save cookie for 60 days
				setCookie("ordersInCart", JSON.stringify(cookieValue), this.oneWeek);

				this.subTotal();
			},

			orderViaChat(value) {
				console.log(value);
				Event.$emit('applied-order', value);
			},
		},

		created() {
			// deleteCookie("ordersInCart")
			this.ordersInCart = JSON.parse(getCookie("ordersInCart"));
			// console.log(this.ordersInCart);

			this.subTotal();
		},

	})
}