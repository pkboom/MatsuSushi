<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Matsu Sushi</title>
	<link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="font-sans bg-white leading-none text-gray-800 antialiased">
	<div id="app">
		@yield('content')
		<flash message="{{ session('flash') }}"></flash>
	</div>

	<script src="{{ mix('js/app.js') }}" defer></script> 
</body>
</html>
