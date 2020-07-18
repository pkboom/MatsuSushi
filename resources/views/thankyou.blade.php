@extends('layouts.app')
@section('content')
<thankyou :transaction="{{ json_encode($transaction) }}"></thankyou>
@endsection('content')