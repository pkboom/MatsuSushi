<template>
	<div class="chat-button-container">
		<a href="javascript:void(0)" class="chat-button" @click="onChatroomOpen" :id="'chatroom'+chatroom_id">{{ chatroom_id }}</a>
	</div>
</template>

<script>
	export default {
		props: [ "chatroom_id"],

		methods: {
			onChatroomOpen() {                
				// console.log(this.chatroom_id);
				// background color back to blue
				this.$emit('chatroomopen', {
					chatroom_id: this.chatroom_id
				});
			}
		}
	}
</script>

<style>
	.chat-button-container {
	}

	.chat-button {
		line-height: 2.5rem;
		background-color: lightgray;
		border-radius: 4px !important;
		box-shadow: none;
		background-clip: padding-box !important;
		border: 0 !important;
		color: white !important;
		padding: .5rem 2rem;
		text-decoration: none !important;
	}
</style>