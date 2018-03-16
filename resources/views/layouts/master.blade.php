 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 	<meta name="csrf-token" content="{{ csrf_token() }}">

 	<title>{{ config('app.name', 'MatsuSushi') }}</title>

	<link href="{{ asset('css/main.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600" rel="stylesheet">

    <style media="screen">
		.font-sans {
			font-family: 'Source Sans Pro', apple-system, BlinkMacSystemFont, 'Helvetica Neue', arial, sans-serif;
		}
    </style>

	@yield('header')
	 
 </head>
 <body class="font-sans text-black">
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