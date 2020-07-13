<!DOCTYPE html>
<html class="h-full bg-gray-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default" defer></script>
    <script src="{{ mix('/js/back/app.js') }}" defer></script>
    @routes
</head>

<body class="font-sans bg-gray-100 leading-none text-gray-800 antialiased">

    @inertia

</body>

</html>