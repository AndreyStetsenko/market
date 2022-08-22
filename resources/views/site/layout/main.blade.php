<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'HashMarket' }}</title>

    <link id="bootstrap" href="{{ asset('site/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('site/css/plugins.css') }}" rel="stylesheet" type="text/css" />    
    <link href="{{ asset('site/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('site/css/de-grey.css') }}" rel="stylesheet" type="text/css" />
    <!-- color scheme -->   
    <link id="colors" href="{{ asset('site/css/colors/scheme-01.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('site/css/coloring.css') }}" rel="stylesheet" type="text/css" />
</head>
<body class="dark-scheme de-grey">

    <div id="wrapper">
        @include('site.layout.header')

        <div class="no-bottom no-top" id="content">
            
            @yield('content')
            
        </div>

        @include('site.layout.footer')
    </div>

    <script src="{{ asset('site/js/plugins.js') }}"></script>
    <script src="{{ asset('site/js/designesia.js') }}"></script>
    @if ( Route::is('index') )
    <script src="{{ asset('site/js/particles.js') }}"></script>
    <script src="{{ asset('site/js/particles-settings.js') }}"></script>
    @endif
    {{-- <script src="{{ asset('site/assets/js/app.js') }}"></script> --}}
</body>
</html>
