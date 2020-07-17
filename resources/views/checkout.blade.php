@extends('layouts.app_new')
@section('header')
<script src="https://js.stripe.com/v3/"></script>
@endsection('header')
@section('content')
<checkout :online-order-enabled="{{ $onlineOrderEnabled }}" stripe-key="{{ $stripeKey }}" :pay-detail="{{ json_encode($payDetail) }}"></checkout>
@endsection('content')