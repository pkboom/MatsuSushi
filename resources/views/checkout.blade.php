@extends('layouts.app')
@section('header')
<script src="https://js.stripe.com/v3/"></script>
@endsection('header')
@section('content')
<checkout :online_order_enabled="{{ $online_order_enabled }}" stripe-key="{{ $stripeKey }}" :pay-detail="{{ json_encode($payDetail) }}"></checkout>
@endsection('content')