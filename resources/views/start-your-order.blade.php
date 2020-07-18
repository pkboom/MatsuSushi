@extends('layouts.app')
@section('content')
<start-your-order :online_order_enabled="{{ $online_order_enabled }}"></start-your-order>
@endsection('content')