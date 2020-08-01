@extends('front.app')
@section('content')
<order :categories="{{ json_encode($categories) }}" popular_menu="{{ $popular_menu }}"></order>
@endsection('content')