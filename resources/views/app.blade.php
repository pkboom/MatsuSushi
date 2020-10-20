<!DOCTYPE html>
<html class="h-full bg-gray-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="restaurant, korean, japanese, matsu, sushi, maki">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default" defer></script>
    <script src="{{ mix('/js/app.js') }}" defer></script>
    @routes
</head>

<body class="font-sans bg-white leading-none text-gray-800 antialiased">

    @inertia

</body>

</html>