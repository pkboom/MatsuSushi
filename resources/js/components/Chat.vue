<template>
    <div>
    	<chat-button v-if="chatButton" @appliedopen="chatIntroOpen"></chat-button>
        <chat-intro v-if="chatIntro" @introopen="chatroomOpen" @appliedclosed="chatroomClosed" :customermessagefromcart="customerMessage"></chat-intro>
        <chat-full-window v-if="chatFullWindow" @appliedclosed="chatroomClosed" :customername="customerName" :customerphonenumber="customerPhoneNumber" :customeraddress="customerAddress" :customermessage="customerMessage"></chat-full-window>
    </div>

</template>

<script>
    import ChatButton from './ChatButton.vue';
    import ChatIntro from './ChatIntro.vue';
    import ChatFullWindow from './ChatFullWindow.vue';

    export default {
        data() {
            return {
                customerName: '',
                customerPhoneNumber: '',
                customerAddress: '',
                customerMessage: '',
                chatButton: true,
                chatIntro: false,
                chatFullWindow: false,
            }
		},

        components: {ChatButton, ChatIntro, ChatFullWindow},
        
        created() {
			// order from cart
			Event.$on('applied-order', (value) => {
				console.log('applied-order received');

				axios.get('/channelon').then( ({data}) => {
					// check if chat is available
					this.channelOpen = data;

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

		methods: {
			chatIntroOpen(value = null) {
				// console.log(value);
				
				let message;
				if ( value ) {
					message = "Order:" + "\n";
					
					Orders.get().forEach((item) => {
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
		}
    }
</script>
