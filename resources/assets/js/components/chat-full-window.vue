<template>
	<div class="chat-window-container-customer">
		<div class="chat-header">
			<a href="javascript:void(0)" class="chat-button" @click="onChatClosed" >Welcome To Matsu Sushi</a>
		</div>
		<div class="chat-full-body">
			<chat-log :messages="messages"></chat-log>
			<chat-composer @messagesent="addMessage"></chat-composer>
		</div>
	</div>
</template>

<script>
export default {
	props: [ "customername", "customerphonenumber", "customeraddress", "customermessage"],

	data() {
		return {
			user_id: 1, // customers don't login
			// name: 'customer', // customers don't login
			messages: [],
			chatrooms: [],
			chatroomID: 0,
		}
	},			

	methods: {
		onChatClosed() {                
			// emitting an event to root scope
			this.$emit('appliedclosed');
			this.leaving();
		},
		
		addMessage(message) {
			if ( this.chatroomID == 0 ) {
				console.log("disconnected");				
			} else {
				message.username = this.customername;
				message.user_id = this.user_id;
				message.chatroomID = this.chatroomID;
				this.messages.push(message);

				// console.log(message);

				axios.post('/messages', message).then(response => {
				})
			}
		},

		leaving() {
			let message = {};
			message.username = this.customername;
			message.user_id = this.user_id;
			message.chatroomID = this.chatroomID;
			message.message = 'User left';
			message.status = 'left';

			axios.post('/messages', message).then(response => {
			})

		},
	},

	created() {
		window.addEventListener('beforeunload', this.leaving);

		axios.post('/getchatroom').then( response => {
			this.chatroomID = response.data.id;
			console.log("new");

			// this.customermessage = this.customermessage.replace(/(\r?\n|\r)/g,"<br />");
			let firstMessage = { 
					message: "name: " + this.customername
						+ "\nphone: " + this.customerphonenumber
						+ "\naddress: " + this.customeraddress
						+ "\n" + this.customermessage,
					status: "new"
				};

			this.addMessage(firstMessage);

			// get messages from db written by this user
			// axios.get('/messages/' + this.chatroomID).then( response => {
			// 	this.messages = response.data;
			// 	console.log(this.messages);
			// });

			// receive messages from admin
			Echo.channel('chatroom.'+ this.chatroomID)
			.listen('MessagePosted', (e) => {
				// console.log(e);

				if (this.chatroomID != 0 ) {
					this.messages.push({
						message: e.message.message,
						username: e.message.username,
						user_id: e.message.user_id,
						chatroomID: response.id
					});									
				}

				//Disconnected
				if (e.message.message == "Disconnected") {
					// add to existing messages
					this.chatroomID = 0;
				}
			});
		});
	},
}


</script>

<style>
.chat-window-container-customer {
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

.chat-full-body {
	background-color: white;
	background-clip: padding-box !important;
	border: 0 !important;
	height: 100%;
	font-size: 0.9rem;
}


</style>