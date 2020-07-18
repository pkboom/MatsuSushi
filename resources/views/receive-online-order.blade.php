@extends('layouts.app')
@section('content')
<receive-online-order :transactions="{{ $transactions }}"></receive-online-order>
@endsection('content')