<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @hasSection('title')
        @yield('title')
    @else
        <title>Проверить robots.txt</title>
    @endif


    <meta name="description" content="Проверить robots.txt">


    {{--<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">--}}

<!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" />
    @yield('css')

</head>
<body>
<div id="app">
    @include('chunks._header')
    @yield('content')
</div>



<!-- Scripts -->
<script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
@yield('js')

</body>
</html>