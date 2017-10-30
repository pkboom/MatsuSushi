<template>
	<div class="chat-window-container">
		<div class="chat-header">
			<a href="javascript:void(0)" @click="onChatClosed" >Welcome To Matsu Sushi</a>
		</div>
		<div class="chat-intro-body">
			<div class="chat-intro-body-wrapper" v-if="!isAdminBusy">
				<p ref='introNameTitle'>{{ nameTitle }}</p>
				<input class="chat-intro-input" placeholder ="Enter a name" type="text" v-model="customerName" @keyup.enter="focusPhoneNumber" ref='introName'>
				<p>{{ phoneTitle }}</p>
				<input class="chat-intro-input" placeholder ="phone number(optional)" type="text" v-model="customerPhoneNumber" @keyup.enter="focusAddress" ref='introNumber'>
				<p>{{ addressTitle }}</p>
				<input class="chat-intro-input" placeholder ="address(optional)" type="text" v-model="customerAddress" @keyup.enter="focusMeassage" ref='introAddress'>
				<p ref='introMessageTitle'>{{ messageTitle }}</p>
				<textarea class="chat-intro-textarea" placeholder ="Type a message..." type="text" v-model="customerMessage" @keyup.enter="startChatting" ref='introMessage' rows="5"></textarea>
				<button class="btn btn-primary chat-intro-button" @click="startChatting">Start Chatting</button>
			</div>
			<div class="chat-intro-body-wrapper" v-if="isAdminBusy">
				<button class="btn btn-primary chat-intro-button" @click="onChatClosed">Close</button>
				<div class="busyAdmin">{{ busyMessage }}</div>
			</div>
		</div>

	</div>
</template>

<script>
export default {
	props: [ 'customermessagefromcart'],

	data() {
		return {
			customerName: "",
			customerPhoneNumber: "",
			customerAddress: "",
			customerMessage: "",
			chatroomID: 0,
			timeoutID: 0,
			nameTitle: "Name:",
			phoneTitle: "Phone:",
			addressTitle: "Address:",
			messageTitle: "Message:",
			busyMessage: "",
			isAdminBusy: false,
		}
	},

	methods: {
		changeMessage() {                
			this.busyMessage = "";
		},
		
		focusPhoneNumber() {                
			this.$refs.introNumber.focus();
		},
		
		focusAddress() {                
			this.$refs.introAddress.focus();
		},
		
		focusMeassage() {                
			this.$refs.introMessage.focus();
		},
		
		onChatClosed() {
			// emitting an event to root scope
			this.$emit('appliedclosed');
		},

		isFull() {
			// check to see if there is a chatroom available
			axios.get('/isfull').then( response => {
				// console.log(response.data);

				if ( !response.data ) {
					// chatroom are full
					console.log('full');

					this.busyMessage = "We’re sorry, but all of our agents are busy. Please contact us in a minute.";

					this.isAdminBusy = true;
				}
			});
		},

		startChatting() {
			if ( this.customerName.length == 0 ) {
				this.nameTitle = "Please enter your name.";
				this.$refs.introNameTitle.style.color = "red";
			} else if ( this.customerMessage == null ) {
				this.messageTitle = "Please type your message."
				this.$refs.introMessageTitle.style.color = "red";
			} else {
				this.isFull();
				if ( !this.isAdminBusy ) {
					// delete a cookie
					document.cookie = "ordersInCart=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

					this.$emit('introopen', {
						name: this.customerName,
						phoneNumber: this.customerPhoneNumber,
						address: this.customerAddress,
						message: this.customerMessage,
					});	
				}
			}
		}
	},

	mounted(){
		this.$refs.introName.focus();
	},

	created() {
		this.isFull();
		this.customerMessage = this.customermessagefromcart;
	},	
}


</script>

<style>
.chat-window-container {
	font-size: 0.8rem;
	border-radius: 4px 4px 0 0 !important;
	position: fixed;
	bottom: 0;
	right: 0;        
	z-index: 1000;      
	width: 300px; 
	height: 450px; 
	text-align: center;
	-webkit-box-shadow: 2px 0px 5px 0px rgba(0,0,0,0.75);
	-moz-box-shadow: 2px 0px 5px 0px rgba(0,0,0,0.75);
	box-shadow: 2px 0px 5px 0px rgba(0,0,0,0.75);
}

.chat-header {
	line-height: 2rem;
	background-color: #4286f4;
	border-radius: 4px 4px 0 0 !important;
	background-clip: padding-box !important;
	border: 0 !important;
}

.chat-header a {
	margin: 0;
	color: white !important;
	text-decoration: none !important;
}

.chat-intro-body {
	background-color: white;
	background-clip: padding-box !important;
	border: 0 !important;
	height: 100%;
}

.chat-intro-body-wrapper {
	display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: center;
	margin: 0 1rem;
	padding: 1rem 0;
}


.chat-intro-body-wrapper p {
	margin-top: .5rem;
	margin-bottom: 0;
	text-align: left;
	padding-left: .3rem;
}

.chat-intro-input, .chat-intro-textarea {
	width: 100%;
	border: solid 1px #7a7a7a;
	border-radius: 4px !important;
	padding: .3rem;
}

.chat-intro-button {
	margin-top: .5rem;
	padding: .5rem 1rem;
	background: #4286f4;
	border-color: #4286f4;
}

.busyAdmin {
	margin: 1rem;
}

</style>