@extends('layouts.app_new')
@section('content')
<start-your-order :online-order="{{ $onlineOrder }}"></start-your-order>
@endsection('content')