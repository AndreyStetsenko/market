@extends('admin.layout.side-menu')

{{ $title = 'Все товары каталога' }}

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('breadcrumb-title')
{{ $title }}
@endsection

@section('subcontent')

    <h2 class="intro-y text-lg font-medium mt-10">{{ $title }}</h2>

    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
        <a href="{{ route('admin.product.create') }}" class="btn btn-primary shadow-md mr-2">Добавить товар</a>
        <div class="hidden md:block mx-auto text-slate-500"></div>
        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
            <div class="dropdown">
                <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                    <span class="flex items-center justify-center">
                        Категории
                    </span>
                </button>
                <div class="dropdown-menu w-40">
                    <ul class="dropdown-content">
                        @foreach ($roots as $root)
                            <li>
                                <a href="{{ route('admin.product.category', ['category' => $root->id]) }}" class="dropdown-item">
                                    {{ $root->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible mt-5">
        <table class="table table-report -mt-2">
            <thead>
                <tr>
                    <th class="whitespace-nowrap">#</th>
                    <th class="whitespace-nowrap">Наименование</th>
                    <th class="whitespace-nowrap">Описание</th>
                    <th class="text-center whitespace-nowrap">Редактировать/Удалить</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="intro-x">
                        <td>{{ $product->id }}</td>
                        <td>
                            <a href="{{ route('admin.product.show', ['product' => $product->id]) }}" class="font-medium whitespace-nowrap">{{ $product->name }}</a>
                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">{{ $product->category->name }}</div>
                        </td>
                        <td>{!! iconv_substr($product->content, 0, 50) !!}</td>
                        <td class="table-report__action w-56">
                            <div class="flex justify-center items-center">
                                <a class="flex items-center mr-3" href="{{ route('admin.product.edit', ['product' => $product->id]) }}">
                                    <i data-feather="check-square" class="w-4 h-4 mr-1"></i>
                                </a>
                                <form action="{{ route('admin.product.destroy', ['product' => $product->id]) }}"
                                        method="post" onsubmit="return confirm('Удалить этот товар?')" class="flex items-center" style="margin-bottom: 0">
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

    {{ $products->links() }}
@endsection
