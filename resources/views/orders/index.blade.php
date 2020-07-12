@extends('layouts.app_new')
@section('content')
<place-order :categories="{{ json_encode($categories) }}"></place-order>
@endsection('content')