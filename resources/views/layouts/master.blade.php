 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

 	<!-- CSRF Token -->
 	<meta name="csrf-token" content="{{ csrf_token() }}">

 	<title>{{ config('app.name', 'MatsuSushi') }}</title>

 	<link href="{{ asset('css/app.css') }}" rel="stylesheet">

	@yield('header') 	
	 
 </head>
 <body>
	<div id="app">

		@include('layouts.nav')

		@yield('content') 	

		@include('layouts.footer')
		
		<flash message="{{ session('flash') }}"></flash>

		{{--  <chat></chat>  --}}
	</div>
	
	<script src="{{ asset('js/app.js') }}"></script> 
	
	@yield('javascript')
 </body>
 </html>