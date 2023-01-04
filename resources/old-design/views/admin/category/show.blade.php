@extends('admin.layout.side-menu')

{{ $title = 'Просмотр категории' }}

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('breadcrumb-title')
{{ $title }}
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">{{ $title }} "{{ $category->name }}"</h2>
    </div>

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 lg:col-span-6">
            <div class="intro-y box px-5 pt-5 mt-5">
                <div class="flex flex-col lg:flex-row border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
                    <div class="mt-6 lg:mt-0 flex-1 px-5 border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                        <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                            <div class="truncate sm:whitespace-normal items-center">
                                <strong>Название:</strong> {{ $category->name }}
                            </div>
                            <div class="truncate sm:whitespace-normal items-center mt-3">
                                <strong>ЧПУ (англ):</strong> {{ $category->slug }}
                            </div>
                            <div class="truncate sm:whitespace-normal items-center mt-3">
                                <strong>Краткое описание</strong>
                                @isset($category->content)
                                    <br>
                                    <p>{{ $category->content }}</p>
                                @else
                                    <br>
                                    <p>Описание отсутствует</p>
                                @endisset
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-1 px-5 items-center justify-center">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                            @php
                                if ($category->image) {
                                    // $url = url('storage/catalog/category/image/' . $category->image);
                                    $url = Storage::disk('public')->url('catalog/category/image/' . $category->image);
                                } else {
                                    $url = Storage::disk('public')->url('catalog/category/image/default.jpg');
                                }
                            @endphp
                            <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="{{ $url }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex mt-10">
        <a href="{{ route('admin.category.edit', ['category' => $category->id]) }}"
            class="btn btn-success">
             Редактировать категорию
        </a>
        <form method="post"
                action="{{ route('admin.category.destroy', ['category' => $category->id]) }}" style="margin-bottom: 0; margin-left: 10px">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">
                Удалить категорию
            </button>
        </form>
    </div>

    @if ($category->children->count())
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">Дочерние категории</h2>
        </div>

        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible mt-5">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">№</th>
                        <th class="whitespace-nowrap">Наименование</th>
                        <th class="whitespace-nowrap">ЧПУ (англ)</th>
                        <th class="whitespace-nowrap"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($category->children as $child)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a href="{{ route('admin.category.show', ['category' => $child->id]) }}">
                                {{ $child->name }}
                            </a>
                        </td>
                        <td>{{ $child->slug }}</td>
                        <td class="table-report__action w-56">
                            <div class="flex justify-center items-center">
                                <a href="{{ route('admin.category.edit', ['category' => $child->id]) }}">
                                    <i data-feather="edit" class="w-4 h-4 mr-1"></i>
                                </a>
                                <form method="post" onsubmit="return confirm('Удалить эту категорию?')"
                                    action="{{ route('admin.category.destroy', ['category' => $child->id]) }}" style="margin-bottom: 0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                                        <i data-feather="trash-2" class="w-4 h-4 mr-1 text-danger"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">Нет дочерних категорий</h2>
        </div>
    @endif
@endsection
