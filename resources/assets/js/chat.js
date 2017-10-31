Vue.component('chat-button', require('./components/chat-button.vue'));
Vue.component('chat-full-window', require('./components/chat-full-window.vue'));
Vue.component('chat-intro', require('./components/chat-intro.vue'));
Vue.component('chat-log', require('./components/chat-log.vue'));
Vue.component('chat-message', require('./components/chat-message.vue'));
Vue.component('chat-composer', require('./components/chat-composer.vue'));	

// chat for customer
if (document.getElementById('app-chat')) {
	const appCustomer = new Vue({ 
		el: '#app-chat',

		created() {
			// order from cart
			Event.$on('applied-order', (value) => {
				console.log('applied-order received');

				axios.get('/channelon').then( response => {
					// check if chat is available
					this.channelOpen = parseInt(response.data[0].occupied);

					// open chat intro if available
					 if ( this.channelOpen ) {
					 	// this.customerMessage = value;
					 	this.chatIntroOpen(value);
					 } else {
					 	alert("We're offline! Please, order via phone.") ;
					 }
				});
			});
		},

		data: {
			customerName: '',
			customerPhoneNumber: '',
			customerAddress: '',
			customerMessage: '',
			chatButton: true,
			chatIntro: false,
			chatFullWindow: false
		},

		methods: {
			chatIntroOpen(value = null) {
				// console.log(value);
				
				let message;
				if ( value ) {
					message = "order:" + "\n";
					
					let cookieValue = JSON.parse(getCookie("ordersInCart"));
					cookieValue.forEach((item) => {
						message += item.title + "(" + item.quantity + ") $" + item.price + "\n";
					});

					message += "Subtotal: $" + value.subtotal + "\n"
						+ "Tax: $" + value.tax + "\n"
						+ "Total: $" + value.total; 
				} 

				this.customerMessage = message;
				this.chatButton = false;
				this.chatIntro = true;
				this.chatFullWindow = false;
			},

			chatroomOpen(message) {
				this.customerName = message.name;
				this.customerPhoneNumber = message.phoneNumber;
				this.customerAddress = message.address;
				this.customerMessage = message.message;

				this.chatButton = false;
				this.chatIntro = false;
				this.chatFullWindow = true;
			},

			chatroomClosed() {
				this.chatButton = true;
				this.chatIntro = false;
				this.chatFullWindow = false;
			},
		},
	})
}