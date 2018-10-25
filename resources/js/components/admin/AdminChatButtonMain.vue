<template>
	<div class="chat-button-container">
		<a href="javascript:void(0)" :class="[{'chat-button-on-color': mainchatbutton}, 'chat-button']" @click="toggleMainButton" id="channelOpenID">{{ showMainButton }}</a>
	</div>
</template>

<script>
	export default {
		props: [ "mainchatbutton"],

		created() {
			// console.log("created mainchatbutton " + this.mainchatbutton);
		},

		methods: {
			toggleMainButton() {
				this.$emit('togglemain');
			},
		},

		computed: {
			showMainButton() {
				return (this.mainchatbutton ? "Chat On" : "Chat Off");
			},
		},
	}
</script>

<style>
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

	.chat-button-on-color {
		background-color: #1daded !important; 
		/* on: blue, off: gray*/
	}
</style>