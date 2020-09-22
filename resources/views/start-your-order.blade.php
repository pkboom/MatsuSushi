@extends('front.app')
@section('header')
<script src="https://js.stripe.com/v3/"></script>
@endsection('header')
@section('content')
<start-your-order  :online_order="{{ json_encode($online_order) }}"></start-your-order>
@endsection('content')