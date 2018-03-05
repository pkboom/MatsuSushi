@extends('layouts.master')

@section('header')
	<link href="{{ asset('css/cart.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div class="container" >
		<div class="wrap cf" id="app-cart">
			<h1 class="projTitle">Matsu Sushi Cart</h1>
			<cart></cart>
		</div>
	</div>
@endsection