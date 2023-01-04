@extends('admin.layout.side-menu')

{{ $title = 'Все категории каталога' }}

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('breadcrumb-title')
{{ $title }}
@endsection

@section('subcontent')

    <h2 class="intro-y text-lg font-medium mt-10">{{ $title }}</h2>

    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
        <a href="{{ route('admin.category.create') }}" class="btn btn-primary shadow-md mr-2">Создать категорию</a>
    </div>

    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible mt-5">
        <table class="table table-report -mt-2">
            <thead>
                <tr>
                    <th class="whitespace-nowrap">Наименование</th>
                    <th class="whitespace-nowrap">Описание</th>
                    <th class="whitespace-nowrap"></th>
                </tr>
            </thead>
            <tbody>
                @include('admin.category.part.tree', ['level' => -1, 'parent' => 0])
            </tbody>
        </table>
    </div>
@endsection