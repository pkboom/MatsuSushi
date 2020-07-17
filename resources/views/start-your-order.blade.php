@extends('layouts.app_new')
@section('content')
<start-your-order :online-order-enabled="{{ $onlineOrderEnabled }}"></start-your-order>
@endsection('content')