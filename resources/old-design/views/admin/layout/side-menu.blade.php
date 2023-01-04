@extends('admin.layout.main')

@section('head')
    @yield('subhead')
@endsection

@section('content')
    @include('admin.layout.components.mobile-menu')
    <div class="flex">
        <!-- BEGIN: Side Menu -->
        <nav class="side-nav">
            <a href="/" class="intro-x flex items-center pl-5 pt-4">
                <img alt="Rubick Tailwind HTML Admin Template" class="w-6" src="{{ asset('dist/images/logo.svg') }}">
                <span class="hidden xl:block text-white text-lg ml-3">
                    HashMarket
                </span>
            </a>
            <div class="side-nav__devider my-6"></div>
            <ul>
                <li>
                    <a href="{{ route('admin.order.index') }}" class="side-menu">
                        <div class="side-menu__title">
                            Заказы
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.user.index') }}" class="side-menu">
                        <div class="side-menu__title">
                            Пользователи
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.referr.index') }}" class="side-menu">
                        <div class="side-menu__title">
                            Реферальная система
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.withdraws') }}" class="side-menu">
                        <div class="side-menu__title">
                            Вывод средств
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.category.index') }}" class="side-menu">
                        <div class="side-menu__title">
                            Категории
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.brand.index') }}" class="side-menu">
                        <div class="side-menu__title">
                            Бренды
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.product.index') }}" class="side-menu">
                        <div class="side-menu__title">
                            Товары
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.page.index') }}" class="side-menu">
                        <div class="side-menu__title">
                            Страницы
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.settings') }}" class="side-menu">
                        <div class="side-menu__title">
                            Настройки
                        </div>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- END: Side Menu -->
        <!-- BEGIN: Content -->
        <div class="content">
            @include('admin.layout.components.top-bar')
            @yield('subcontent')
        </div>
        <!-- END: Content -->
    </div>
@endsection
