<template>
	<div class="chat-composer">
		<textarea rows="1" type="text" placeholder ="Type a message..." v-model="messageText" @keyup.enter="sendMessage" ref='composertextarea'></textarea> 
		<!-- <button class="btn btn-primary" @click="sendMessage" id="sendMessage">Send</button> -->
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
				this.$emit('messagesent', {
					message: tempText,
					status: "chatting"
				});
			}
			this.messageText = null;				
		}
	},

	mounted(){
		this.$refs.composertextarea.focus();
	},

}

</script>

<style>
.chat-composer {
	margin: 0.5rem;
	font-size: .9rem;
	display: flex;
	justify-content: center;
}

.chat-composer textarea {
	flex: 0.8 auto;
	padding: 0.5rem;
	border-radius: 4px !important;
	resize: none;
	overflow: hidden;
}

</style>