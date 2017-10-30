@extends('layouts.master')

@section('content')
<?php $nav_menu = "active"; ?>

<div class="container menu" id="app-menu">
	<add-to-cart v-show="ordered"> @{{ orderItemTitle }} </add-to-cart>
	<h2>Matsu Sushi Menu</h2>
	<div id="menuAccordion" data-children=".item">
		<matsu-menu-category v-for="(value, index) in subCategoryInfo" :key="index" :count="index" :subcategoryitem="value" @applied="onOrderMenu"></matsu-menu-category>
	</div>
</div><!-- /.container -->

@endsection('content')
