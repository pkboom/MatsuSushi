@extends('admin.master')

@section('content')

<?php $admin_chat = "active"; ?>

<audio id="messageAlarm">
  <source src="/sound/jingle-bells-sms.ogg" type="audio/ogg">
  Your browser does not support the audio element.
</audio>

<div class="container" id="admin-app-chat">
	<div class="row">
		<div class="col-4">
			{{-- defualt: 10 chatrooms --}}
			<admin-chat-button-master :mainchatbutton="mainChatButton" @channelon="channelOn"></admin-chat-button-master>
			<admin-chat-button v-for="chatroom in chatrooms" :key="chatroom.id" :chatroomid="chatroom.id" @chatroomopen="openChatroom"></admin-chat-button>
		</div>
		<div class="col-8">
			<div class="chat-window-container">
				<div class="chat-body">
					<admin-chat-log v-show="chatBody" :messages="messages"></admin-chat-log>
					<admin-chat-composer v-show="chatBody" @messagesent="addMessage" @disconnect-message="disconnectMessage"></admin-chat-composer>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection('content')

