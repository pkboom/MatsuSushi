@extends('layouts.app_new')
@section('content')
<thankyou :transaction="{{ json_encode($transaction) }}"></thankyou>
@endsection('content')