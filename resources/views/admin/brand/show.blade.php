@extends('admin.layout.side-menu')

{{ $title = 'Просмотр бренда' }}

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('breadcrumb-title')
{{ $title }}
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">{{ $title }} "{{ $brand->name }}"</h2>
    </div>

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 lg:col-span-6">
            <div class="intro-y box px-5 pt-5 mt-5">
                <div class="flex flex-col lg:flex-row border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
                    <div class="mt-6 lg:mt-0 flex-1 px-5 border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                        <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                            <div class="truncate sm:whitespace-normal items-center">
                                <strong>Название:</strong> {{ $brand->name }}
                            </div>
                            <div class="truncate sm:whitespace-normal items-center mt-3">
                                <strong>ЧПУ (англ):</strong> {{ $brand->slug }}
                            </div>
                            <div class="truncate sm:whitespace-normal items-center mt-3">
                                <strong>Краткое описание</strong>
                                @isset($brand->content)
                                    <br>
                                    <p>{{ $brand->content }}</p>
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
                                if ($brand->image) {
                                    // $url = url('storage/catalog/brand/source/' . $brand->image);
                                    $url = Storage::disk('public')->url('catalog/brand/image/' . $brand->image);
                                } else {
                                    // $url = Storage::disk('public')->url('catalog/brand/image/' . $brand->image);
                                    $url = Storage::disk('public')->url('catalog/brand/image/default.jpg');
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
        <a href="{{ route('admin.brand.edit', ['brand' => $brand->id]) }}"
            class="btn btn-success">
             Редактировать бренд
        </a>
        <form method="post" onsubmit="return confirm('Удалить этот бренд?')"
                action="{{ route('admin.brand.destroy', ['brand' => $brand->id]) }}" style="margin-bottom: 0; margin-left: 10px">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">
                Удалить бренд
            </button>
        </form>
    </div>
@endsection

