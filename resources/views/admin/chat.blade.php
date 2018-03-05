@extends('admin.master')

@section('content')
	<audio id="messageAlarm">
		<source src="/sound/jingle-bells-sms.ogg" type="audio/ogg">
		Your browser does not support the audio element.
	</audio>
	
	<admin-chat></admin-chat>
@endsection

