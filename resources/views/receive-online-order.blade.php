@extends('layouts.app_new')
@section('content')
<receive-online-order :transactions="{{ $transactions }}"></receive-online-order>
@endsection('content')