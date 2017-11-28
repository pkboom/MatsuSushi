<template>
	<div class="chat-button-container">
		<a href="javascript:void(0)" class="chat-button" @click="onChatOpen" ><i class="fa fa-comment-o"></i><span class="weareonline">{{ chatButtonTitle }}</span></a>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				chatButtonTitle: "",
				channelOpen: 0
			}
		},			

		created() {
			axios.get('/channelon').then( response => {
				this.channelOpen = response.data;
				this.chatButtonTitle = ( this.channelOpen ? "We're online!" : "We're offline!" );
			});
		},

		methods: {
			onChatOpen() {
				if ( this.channelOpen ) {
					// We're online!
					// emitting an event to root scope
					this.$emit('appliedopen');

				}
			}
		}
	}
	
</script>

<style>
	.chat-button-container {
		position: fixed;
		bottom: 0;
		right: 0.5rem;		
		z-index: 1000;	    
	}

	.chat-button {
		line-height: 2.5rem;
		background-color: #4286f4;
		border-radius: 4px !important;
		box-shadow: none;
		background-clip: padding-box !important;
		border: 0 !important;
		color: white !important;
		padding: .5rem 2rem;
		text-decoration: none !important;
	}

	.weareonline {
		margin-left: 0.5rem;
	}
</style>