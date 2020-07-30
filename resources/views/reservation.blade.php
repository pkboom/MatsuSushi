@extends('front.app')
@section('content')
<reservation :reservation_enabled="{{ $reservation_enabled }}" encrypted_time="{{ $encrypted_time }}"></reservation>
@endsection('content')