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
    <link rel="stylesheet" href="//cdn.quilljs.com/1.3.6/quill.bubble.css">
    <link rel="stylesheet" href="//cdn.quilljs.com/1.3.6/quill.snow.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css">
    <link rel="stylesheet" href="{{ asset('site/assets/style.css') }}">
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
    {{-- <script src="{{ asset('site/assets/vendor/jquery-3.4.0/jquery-3.4.0.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('site/assets/vendor/validate/jquery.validate.min.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>
    <script src="{{ asset('site/assets/js.bundle.js') }}"></script>

    <script type="module">
        import { Fancybox } from "https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.esm.js";

        Fancybox.bind('[data-fancybox="gallery"]', {
            caption: function (fancybox, carousel, slide) {
                return (
                    `${slide.index + 1} / ${carousel.slides.length} <br />` + slide.caption
                );
            },
        });
    </script>

    @stack('scripts')
</body>
</html>
