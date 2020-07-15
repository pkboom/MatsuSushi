@extends('layouts.app_new')
@section('content')
<checkout online-order="{{ $onlineOrder }}" enabled="{{ $enabled }}"></checkout>
@endsection('content')