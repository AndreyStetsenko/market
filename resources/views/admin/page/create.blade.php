@extends('admin.layout.side-menu')

{{ $title = 'Создание новой страницы' }}

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('breadcrumb-title')
{{ $title }}
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">

            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">{{ $title }}</h2>
                </div>
                <div id="input" class="p-5">
                    <form class="preview" method="post" action="{{ route('admin.page.store') }}">
                        @csrf

                        @include('admin.page.part.form')
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
