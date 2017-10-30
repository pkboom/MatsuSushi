<template>
	<div  class="clearfix chat-message">
		<p class="messageTitle" :class="{'align-right': ( message.user_id != 1 ? 1 : 0 )}"><span v-if="message.user_id != 1">{{ message.created_at }}&nbsp;</span>{{ message.username }}<span v-if="message.user_id == 1">&nbsp;{{ message.created_at }}</span></p>
		<p class="customerMessage" :class="{'adminMessage': ( message.user_id != 1 ? 1 : 0 )}">{{ message.message }}</p>
	</div>
</template>

<script>
export default {
	props: [ 'message' ],
}

</script>

<style lang="css">
*, *:before, *:after {
	box-sizing: border-box;
}

.chat-message {
	padding: 0.5rem 1rem;
	text-align: center;
}

.messageTitle {
	display: block;
	margin: 0.5rem 0;
	text-align: left; 
}

.customerMessage {
	word-wrap:break-word;
	display: block;
	background: #86BB71;
	color: white;
	line-height: 26px;
	border-radius: 7px;
	width: fit-content;
	width: -webkit-fit-content;
	width: -moz-fit-content;
	max-width: 80%;
	padding: 0.5rem 0.7rem;
	position: relative;
	margin-bottom: 0;
	min-width: 66px;
	text-align: left;
	white-space: pre-wrap;
}

.customerMessage:after {
	bottom: 100%;
	border: solid transparent;
	content: " ";
	height: 0;
	width: 0;
	position: absolute;
	pointer-events: none;
	border-width: 10px;
	border-bottom-color: #86BB71;
	left: 1.3rem;
}

.adminMessage {
	background: #94C2ED;
	float:right;
	position: relative;
}

.adminMessage:after {
	border-bottom-color: #94C2ED;
	right: 1.3rem;
	left: unset;
}

.align-right {
	text-align: right;
}

.clearfix:after {
	visibility: hidden;
	display: block;
	font-size: 0;
	content: " ";
	clear: both;
	height: 0;
}

</style>