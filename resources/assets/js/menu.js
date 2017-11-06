Vue.component('matsu-menux', require('./components/matsu-menux.vue'));
Vue.component('matsu-menu-category', require('./components/matsu-menu-category.vue'));
Vue.component('add-to-cart', require('./components/add-to-cart.vue'));

if (document.getElementById('app-menu')) {
	const appMenu = new Vue({
		el: '#app-menu',

		data: 
		{
			oneWeek: 7,
			subCategoryCount: 15,
			ordered: false,
			orderItemTitle: '',
			orderItemPrice: '',
			orderItemCount: 0,
			orderItems: [],
			category: [],
		},

		created() {
			let cookieValue = JSON.parse(getCookie("ordersInCart"));

			cookieValue ? this.orderItems = cookieValue : console.log("no cookie");

			axios.get('/menu/category').then( response => {
				// console.log(response.data);
				this.category = response.data;
			});
		},

		methods: {
			onOrderMenu(order) {
				// used in popup
				console.log(order);
				this.orderItemTitle = order.name;

				this.orderItems.push(order);
				// show order info popup
				this.ordered = true;
				
				// save cookie for 60 days
				setCookie("ordersInCart", JSON.stringify(this.orderItems), this.oneWeek);

				// update cart badges
				document.getElementById("cart-badge").textContent = this.orderItems.length;

				// order message disappears in 2 sec
				setTimeout(() => {
					this.ordered = false;
				}, 2 * 1000); 
			}
		}
	})
}