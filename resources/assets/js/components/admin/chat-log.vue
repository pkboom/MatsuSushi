<template>
	<div class="chat-log">
		<admin-chat-message v-for="message in messages" :key="messages.message" :message="message"></admin-chat-message>
		<dir id="jumpToHere"></dir>
		<div class="empty" v-show="messages.length == 0">
			No messages!
		</div>
	</div>
</template>

<script>
export default {
	props: [ "messages"],
	
	// whenever messages changes, this function will run
	watch: {
		messages: function() {
			setTimeout(this.jumpToBottom, 1);
		},
	},

	methods: {
		jumpToBottom() {
			let container = document.querySelector('#jumpToHere');
			container.scrollIntoView();
		}
	}
}
</script>

<style lang="css">
/*	.chat-log .chat-message:nth-child(even) {
		background-color: #ccc;
	}
	*/	
	.chat-log {
		height: 60vh;
		overflow-y: auto;
		margin: 1rem 0;
	}

	.empty {
		padding: 1rem;
		text-align: center;
	}
	</style>