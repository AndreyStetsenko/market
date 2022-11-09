@extends('admin.layout.side-menu')

{{ $title = 'Настройки' }}

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('breadcrumb-title')
{{ $title }}
@endsection

@section('subcontent')
    <h2 class="intro-y text-lg font-medium mt-10">{{ $title }}</h2>

    @if(Session::has('error'))
    <div class="alert alert-danger mt-3">
        {{ Session::get('error') }}
        @php
            Session::forget('error');
        @endphp
    </div>
    @endif

    @if(Session::has('success'))
    <div class="alert alert-success mt-3">
        {{ Session::get('success') }}
        @php
            Session::forget('success');
        @endphp
    </div>
    @endif

    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible mt-5">
        <form action="{{ route('admin.settings.clear.products') }}" method="post">
            @csrf

            <button class="btn btn-danger" type="submit" onclick="if(confirm('Bы уверены, что хотите уничтожить товары?')) return true; else return false;">Удалить все товары</button>
        </form>

        <form action="{{ route('admin.settings.clear.images') }}" method="post">
            @csrf

            <button class="btn btn-danger" type="submit" onclick="if(confirm('Bы уверены, что хотите уничтожить картинки?')) return true; else return false;">Удалить все картинки</button>
        </form>
    </div>
@endsection

