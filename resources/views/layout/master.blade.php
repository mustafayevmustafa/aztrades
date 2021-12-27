<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:image" content="{{ asset('image/logo.png') }}" />
    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <!-- Flags Css-->
    <link href="{{ asset('assets/css/flags.css') }}" id="app-style" rel="stylesheet" type="text/css" />
</head>

<body>
    @include('layout/header')
    <main>@yield('content')</main>
    @include('layout/footer')
    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
