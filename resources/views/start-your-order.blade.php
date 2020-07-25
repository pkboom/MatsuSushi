@extends('front.app')
@section('header')
<script src="https://js.stripe.com/v3/"></script>
@endsection('header')
@section('content')
<start-your-order :online_order_enabled="{{ $online_order_enabled }}"></start-your-order>
@endsection('content')