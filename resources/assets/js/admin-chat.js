Vue.component('admin-chat-button-main', require('./components/admin/chat-button-main.vue'));
Vue.component('admin-chat-button', require('./components/admin/chat-button.vue'));
Vue.component('admin-chat-log', require('./components/admin/chat-log.vue'));
Vue.component('admin-chat-message', require('./components/admin/chat-message.vue'));
Vue.component('admin-chat-composer', require('./components/admin/chat-composer.vue'));	

// chat for admin
if (document.getElementById('admin-app-chat')) {
	const appAdmin = new Vue({ 
		el: '#admin-app-chat',

		data: {
			chatBody: false,
			adminID: 0,
			adminName: '',
			chatrooms: [],
			activeChatroom: 0,
			messages: [],
			mainChatButton: 0 // main chatbutton on/off
		},

		methods: {
			addMessage(message) {
				console.log(message);

				// add to existing messages
				message.username = this.adminName;
				message.user_id = this.adminID;
				message.chatroomID = this.activeChatroom;
				// message.status = "chatting";
				message.created_at = new Date().toLocaleString();
				this.messages.push(message);

				// send mesaage
				axios.post('/messages', message).then(response => {
					// Do whatever;
				})

				if ( parseInt(this.activeChatroom) > 0 ) {
					document.getElementById("chatroom" + this.activeChatroom).style.backgroundColor = "#1daded";
				}
			},

			// start chatting
			openChatroom(message) {
				this.chatBody = true;

				if ( this.activeChatroom != 0 ) {
					// turn background color back to 'gray'
					document.getElementById("chatroom" + this.activeChatroom).style.backgroundColor = "lightgray";
				}

				this.activeChatroom = message.chatroomID;

				// turn background button color to 'blue'
				document.getElementById("chatroom" + this.activeChatroom).style.backgroundColor = "#1daded";

				this.messages = [];
				// get messages from db written by this user
				axios.get('/admin/messages/' + this.activeChatroom).then( response => {
					this.messages = response.data;
					console.log(this.messages);
				});
			},

			inactiveChatroom(chatroomID) {
				// add to existing messages
				let message = {};

				message.message = 'Disconnected';
				message.username = this.adminName;
				message.user_id = this.adminID;
				message.chatroomID = chatroomID;
				message.status = "disconnected";
				message.created_at = new Date().toLocaleString();
				
				if ( this.activeChatroom == chatroomID ) {
					this.messages.push(message);
				}

				// send 'Disconnected'
				axios.post('/messages', message).then(response => {
					// Do whatever;
				})

				// unoccupy a chatroom
				axios.post('/leavechatroom/' + chatroomID).then( response => {
					console.log("leaving a chatroom" + chatroomID);
				});

			},

			disconnectMessage() {
				this.inactiveChatroom(this.activeChatroom);	
				// window.clearTimeout(this.timeoutID[this.activeChatroom]);
			},

			// channelOn(message = '') {
			toggleMain() {
				this.mainChatButton = !this.mainChatButton;

				// close chat screen
				this.chatBody = false;
				this.activeChatroom = 0;

				// chat on/off
				axios.post('/chat/main', { mainButton: this.mainChatButton })
				.then( response => {
					console.log("channel on/off");
				});

				// if ( message == 'mobile' ) {
				// 	this.addMessage({
				// 		message: "togglemainbutton",
				// 		status: "togglemainbutton"
				// 	});					
				// } 
			}
		},
		
		created() {	
			// get user id & name
			this.adminID = document.getElementById("adminID").innerHTML;
			this.adminName = document.getElementById("adminName").innerHTML;

			axios.get('/channelon').then( response => {
				this.mainChatButton = parseInt(response.data[0].occupied);
				console.log("/channelon " + this.mainChatButton);
			});

			// messages coming from mobile
			Echo.channel('chatroom.0')
			.listen('MessagePosted', (e) => {
				if ( e.message.status == 'mobile-togglemainbutton' ) {
					// console.log("mobile-togglemainbutton");
					// this.channelOn("mobile");
				}
			});

			// get chatrooms of an admin(default: 5)
			// to open all of them
			axios.get('/chatroom/' + this.adminID).then( response => {
				// get every chatroom info
				this.chatrooms = response.data;

				// this.activeChatroom = this.chatrooms[0].id;

				return this.chatrooms;

			}).then( responses => {
				responses.forEach((response) => {

					axios.get('/lastmessages/' + response.id).then( lastMessage => {
						// if last message is either 'disconnected' or 'user left', gray
						// if not, turn button to tomato
						if ( lastMessage.data === "chat finished" ) {
							document.getElementById("chatroom" + response.id).style.backgroundColor = "lightgray";
							
							// unoccupy a chatroom
							axios.post('/leavechatroom/' + response.id).then( response => {
								// console.log("leaving a chatroom" + e.message.chatroomID);
							});
						} else {
							document.getElementById("chatroom" + response.id).style.backgroundColor = "tomato";
						}
					});

					// open 5 chatrooms per admin
					Echo.channel('chatroom.' + response.id)
					.listen('MessagePosted', (e) => {

						if ( e.message.status == 'new' ) {
							// sound a notification
							console.log("new");
							document.getElementById("messageAlarm").play(); 
						}

						// user left
						if ( e.message.status == 'left' ) {
							console.log("left");
							// unoccupy a chatroom
							axios.post('/leavechatroom/' + e.message.chatroomID).then( response => {
								// console.log("leaving a chatroom" + e.message.chatroomID);
							});
						} else {
							// chatting now
							// change color of chatroom with a new message
							document.getElementById("chatroom" + e.message.chatroomID).style.backgroundColor = "tomato";
						}

						// update a chatroom with a new message
						if ( this.activeChatroom == e.message.chatroomID ) {

							// console.log(e.message);

							this.messages.push({
								message: e.message.message,
								username: e.message.username,
								user_id: e.message.user_id,
								chatroomID: e.message.chatroomID,
								created_at: new Date().toLocaleString()
							});
						}
					});
				});				
			});				
		}
	})
}