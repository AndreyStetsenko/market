@extends('admin.layout.side-menu')

{{ $title = 'Все бренды каталога' }}

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('breadcrumb-title')
{{ $title }}
@endsection

@section('subcontent')
    <h2 class="intro-y text-lg font-medium mt-10">{{ $title }}</h2>

    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
        <a href="{{ route('admin.brand.create') }}" class="btn btn-primary shadow-md mr-2">Создать бренд</a>
    </div>

    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible mt-5">
        <table class="table table-report -mt-2">
            <thead>
                <tr>
                    <th class="whitespace-nowrap">Наименование</th>
                    <th class="whitespace-nowrap">Описание</th>
                    <th class="text-center whitespace-nowrap"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($brands as $brand)
                    <tr class="intro-x">
                        <td class="w-72">
                            <a href="{{ route('admin.brand.show', ['brand' => $brand->id]) }}">
                                {{ $brand->name }}
                            </a>
                        </td>
                        <td>
                            {!! iconv_substr($brand->content, 0, 50) !!}
                        </td>
                        <td class="table-report__action w-56">
                            <div class="flex justify-center items-center">
                                <a class="flex items-center mr-3" href="{{ route('admin.brand.edit', ['brand' => $brand->id]) }}">
                                    <i data-feather="check-square" class="w-4 h-4 mr-1"></i>
                                </a>
                                <form action="{{ route('admin.brand.destroy', ['brand' => $brand->id]) }}"
                                        method="post" onsubmit="return confirm('Удалить этот бренд?')" class="flex items-center" style="margin-bottom: 0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                                        <i data-feather="trash-2" class="w-4 h-4 mr-1"></i>
                                    </button>
                              </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
