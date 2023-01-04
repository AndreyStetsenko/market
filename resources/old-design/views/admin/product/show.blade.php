@extends('admin.layout.side-menu')

{{ $title = 'Просмотр товара' }}

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('breadcrumb-title')
{{ $title }}
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">{{ $title }} "{{ $product->name }}"</h2>
    </div>

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 lg:col-span-6">
            <div class="intro-y box px-5 pt-5 mt-5">
                <div class="flex flex-col lg:flex-row border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
                    <div class="mt-6 lg:mt-0 flex-1 px-5 border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                        <div class="flex flex-col justify-center items-center lg:items-start mt-4">

                            <div class="truncate sm:whitespace-normal items-center">
                                <strong>Название:</strong> {{ $product->name }}
                            </div>
                            
                            <div class="truncate sm:whitespace-normal items-center mt-3">
                                <strong>ЧПУ (англ):</strong> {{ $product->slug }}
                            </div>

                            <div class="truncate sm:whitespace-normal items-center mt-3">
                                <strong>Бренд:</strong> {{ $product->brand->name }}
                            </div>

                            <div class="truncate sm:whitespace-normal items-center mt-3">
                                <strong>Категория:</strong> {{ $product->category->name }}
                            </div>

                            <div class="truncate sm:whitespace-normal items-center mt-3">
                                <strong>Новинка:</strong> @if($product->new) да @else нет @endif
                            </div>

                            <div class="truncate sm:whitespace-normal items-center mt-3">
                                <strong>Лидер продаж:</strong> @if($product->hit) да @else нет @endif
                            </div>

                            <div class="truncate sm:whitespace-normal items-center mt-3">
                                <strong>Распродажа:</strong> @if($product->sale) да @else нет @endif
                            </div>

                            <div class="truncate sm:whitespace-normal items-center mt-3">
                                <strong>Автор:</strong> <a href="{{ route('admin.user.edit', $product->creator->id) }}" target="_blank">{{ $product->creator->name }}</a>
                            </div>

                        </div>
                    </div>
                    <div class="flex flex-1 px-5 items-center justify-center">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                            @php
                                if ($product->image) {
                                    $url = url('storage/catalog/product/image/' . $product->image);
                                } else {
                                    $url = url('storage/catalog/product/image/default.jpg');
                                }
                            @endphp
                            <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="{{ $url }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-12 lg:col-span-6">
            <div class="intro-y box px-5 pt-5 pb-5 mt-5">

                <strong class="block mb-3">Описание</strong>
                
                @isset($product->content)
                    <p>{!! $product->content !!}</p>
                @else
                    <p>Описание отсутствует</p>
                @endisset

            </div>
        </div>
    </div>

    <div class="flex mt-5">
        <a href="{{ route('admin.product.edit', ['product' => $product->id]) }}"
            class="btn btn-success">
            Редактировать товар
        </a>
        <form method="post" class="d-inline" onsubmit="return confirm('Удалить этот товар?')"
            action="{{ route('admin.product.destroy', ['product' => $product->id]) }}" style="margin-bottom: 0; margin-left: 10px">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">
                Удалить товар
            </button>
        </form>
    </div>
@endsection
