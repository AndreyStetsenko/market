@extends('admin.layout.main')

@section('head')
    @yield('subhead')
@endsection

@section('content')
    @include('admin.layout.components.mobile-menu')
    <div class="flex">
        <!-- BEGIN: Simple Menu -->
        <nav class="side-nav side-nav--simple">
            <a href="" class="intro-x flex items-center pl-5 pt-4">
                <img alt="Rubick Tailwind HTML Admin Template" class="w-6" src="{{ asset('dist/images/logo.svg') }}">
            </a>
            <div class="side-nav__devider my-6"></div>
            <ul>
                
            </ul>
        </nav>
        <!-- END: Simple Menu -->
        <!-- BEGIN: Content -->
        <div class="content">
            @include('admin.layout.components.top-bar')
            @yield('subcontent')
        </div>
        <!-- END: Content -->
    </div>
@endsection
