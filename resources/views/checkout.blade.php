@extends('layouts.app_new')
@section('header')
<script src="https://js.stripe.com/v3/"></script>
@endsection('header')
@section('content')
<checkout online-order="{{ $onlineOrder }}" enabled="{{ $enabled }}" stripe-key="{{ $stripeKey }}"></checkout>
@endsection('content')