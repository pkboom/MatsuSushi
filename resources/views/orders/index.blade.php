@extends('layouts.app_new')
@section('content')
<order :categories="{{ json_encode($categories) }}"></order>
@endsection('content')