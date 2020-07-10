
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>admin</title>

	<link href="{{ mix('css/app.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet">

    <style media="screen">
            .font-sans {
                font-family: 'Source Sans Pro', apple-system, BlinkMacSystemFont, 'Helvetica Neue', arial, sans-serif;
            }
    </style>

	@yield('header')

</head>
<body class="my-8">
	<div id="app">
		@include('admin.nav')

		<div class="mt-8 mx-8 pt-8">
			@yield('content')
		</div>

		<flash message="{{ session('flash') }}"></flash>
	</div>

	<script src="{{ mix('js/app.js') }}" defer></script> 

	@yield('javascript')
</body>
</html>
