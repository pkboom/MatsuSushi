<div id="app-chat">
	<chat-button v-if="chatButton" @appliedopen="chatIntroOpen"></chat-button>
	<chat-intro v-if="chatIntro" @introopen="chatroomOpen" @appliedclosed="chatroomClosed" :customermessagefromcart="customerMessage"></chat-intro>
	<chat-full-window v-if="chatFullWindow" @appliedclosed="chatroomClosed" :customername="customerName" :customerphonenumber="customerPhoneNumber" :customeraddress="customerAddress" :customermessage="customerMessage"></chat-full-window>
</div>