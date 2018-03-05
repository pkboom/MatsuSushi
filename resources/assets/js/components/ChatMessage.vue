<template>
	<div  class="clearfix chat-message">
		<p class="messageTitle" :class="{'align-right': ( message.user_id != 1 ? 0 : 1 )}">{{ message.username }}</p>
		<p class="adminMessage" :class="{'customerMessage': ( message.user_id != 1 ? 0 : 1 )}">{{ message.message }}</p>
	</div>
</template>

<script>
export default {
	props: [ "message" ],
}
</script>

<style lang="css">
*, *:before, *:after {
	box-sizing: border-box;
}

.chat-message {
	padding: 0 1rem;
}

.messageTitle {
	display: block;
	margin: 0.5rem;
	text-align: left;
}

.adminMessage {
	word-wrap:break-word;
	display: block;
	background: #86BB71;
	color: white;
	line-height: 26px;
	border-radius: 7px;
	width: -webkit-fit-content;
	width: -moz-fit-content;
	width: fit-content;
	max-width: 80%;
	padding: 0.1rem 0.5rem;
	position: relative;
	margin-bottom: 0;
	min-width: 20%;
	text-align: left;
}

.adminMessage:after {
	bottom: 100%;
	border: solid transparent;
	content: " ";
	height: 0;
	width: 0;
	position: absolute;
	pointer-events: none;
	border-width: 10px;
	border-bottom-color: #86BB71;
	left: 0.7rem;
}

.customerMessage {
	background: #94C2ED;
	float:right;
	position: relative;
	margin-bottom: 0;
	white-space: pre-wrap;
}

.customerMessage:after {
	border-bottom-color: #94C2ED;
	right: 0.7rem;
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