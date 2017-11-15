@extends('layouts.master')

@section('content')
{{-- https://codepen.io/alex_rodrigues/pen/ABGdg --}}
<div class="container" >
	<div class="wrap cf" id="app-cart">
		<h1 class="projTitle">Matsu Sushi Cart</h1>
		<div class="cart">
			<cart-list :orders="ordersInCart" @appliedremove="onRemoveOrder" @appliedquantity="onQuantityChanged"></cart-list>
		</div>
		<div class="subtotal cf">
			<cart-total :subtotal="subtotalInCart" @appliedorderviachat="orderViaChat"></cart-total>
		</div>
	</div>
</div><!-- /.container -->

@endsection('content')
