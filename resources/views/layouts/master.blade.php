 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

 	<!-- CSRF Token -->
 	<meta name="csrf-token" content="{{ csrf_token() }}">

 	<meta name="description" content="">
 	<meta name="author" content="">

 	<title>Matsu Sushi</title>

 	<!-- Bootstrap core CSS -->
 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
 	<!-- lightgallery -->
 	<link href="https://cdn.rawgit.com/sachinchoolur/lightgallery.js/master/dist/css/lightgallery.css" rel="stylesheet">
 	<!-- justified gallery -->
 	<link rel="stylesheet" href="/css/justifiedGallery.min.css" />
 	{{-- fontawesome --}}
 	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
 	<!-- Custom styles for this template -->
 	<link href="/css/app.css" rel="stylesheet">
 	<link href="/css/cart.css" rel="stylesheet">

 	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
 	<link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
 	<link href="https://fonts.googleapis.com/css?family=Source+Code+Pro" rel="stylesheet">
 	<link href="/css/stripe/main.css" rel="stylesheet">
 	<link href="/css/stripe/form.css" rel="stylesheet">

 </head>
 <body>

 	@include('layouts.nav')

 	@yield('content') 	

 	@include('layouts.footer')

 	@include('chat') 	

 	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
 	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
 	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
 	<script src="/js/holder.js"></script>

{{--  	<script src="https://js.stripe.com/v3/"></script>
 	<script src="/js/stripe/index.js"></script>
 	<script src="/js/stripe/example3.js"></script>
 --}} 	
 	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
 	<script src="/js/ie10-viewport-bug-workaround.js"></script>

 	<script src="/js/app.js"></script> 
 </body>
 </html>