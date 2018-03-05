
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>admin</title>

	<link href="{{ asset('css/app.css') }}" rel="stylesheet">

	@yield('header')

</head>
<body class="my-8">
	<div id="app">
		@include('admin.nav')

		<div class="mt-4 mx-8">
			@yield('content')
		</div>

		<flash message="{{ session('flash') }}"></flash>
	</div>

	<script src="{{ asset('js/app.js') }}"></script> 

	@yield('javascript')
</body>
</html>
