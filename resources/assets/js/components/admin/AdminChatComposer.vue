<template>
	<div class="chat-composer">
		<button class="btn btn-warning" @click="sendDisconnect">Disconnect</button>
		<textarea rows="2" type="text" placeholder ="Type a message..." v-model="messageText" @keyup.enter="sendMessage" ref='composertextarea'></textarea> 
	</div>
</template>

<script>
export default {
	data() {
		return {
			messageText: ""
		}
	},

	methods: {
		sendMessage() {                
			let tempText = this.messageText;
			tempText = tempText.replace(/(\r?\n|\r)/,"");

			if ( tempText.length > 0 ) {
				// emitting an event to root scope
				this.$emit('messagesent', {
					message: tempText,
					status: "chatting"
				});
			}

			this.messageText = null;
		},

		// disconnect
		sendDisconnect() {                
			this.$emit('disconnect-message');
		}
	}
}

</script>

<style>
.chat-composer {
	margin: 1rem 2rem;
	display: flex;
	justify-content: center;
}

.chat-composer textarea {
	flex: 0.8 auto;
	padding: 0.5rem;
	border-radius: 4px !important;
	resize: none;
}

.chat-composer button {
	margin-right: 1rem;
}

</style>