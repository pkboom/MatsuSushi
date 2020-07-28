@extends('front.app')
@section('content')
<reservation :reservation_enabled="{{ $reservation_enabled }}"></reservation>
@endsection('content')