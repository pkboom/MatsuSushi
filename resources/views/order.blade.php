@extends('front.app')
@section('content')
<order :categories="{{ json_encode($categories) }}"></order>
@endsection('content')