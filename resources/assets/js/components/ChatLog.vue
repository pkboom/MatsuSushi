<template>
	<div class="chat-log">
		<chatmessage v-for="message in messages" :key="messages.message" :message="message"></chatmessage>
		<dir id="jumpToHere"></dir>
		<div class="empty" v-show="messages.length == 0">
			Chat started!
		</div>
	</div>
</template>

<script>
import chatmessage from './chat-message.vue';

export default {
	props: [ "messages"],

	components: { chatmessage },

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
		height: 77%;
		overflow-y: auto;
		width: 100%;
	}

	.empty {
		padding: 1rem;
		text-align: center;
	}
	</style>