@extends('admin.layout.side-menu')

{{ $title = 'Просмотр страницы' }}

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('breadcrumb-title')
{{ $title }}
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">{{ $title }} "{{ $page->name }}"</h2>
    </div>

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 lg:col-span-6">
            <div class="intro-y box px-5 pt-5 mt-5">
                <div class="flex flex-col lg:flex-row border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
                    <div class="mt-6 lg:mt-0 flex-1 px-5 border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                        <div class="flex flex-col justify-center items-center lg:items-start">
                            <div class="truncate sm:whitespace-normal items-center">
                                <strong>Название:</strong> {{ $page->name }}
                            </div>
                            <div class="truncate sm:whitespace-normal items-center mt-3">
                                <strong>ЧПУ (англ):</strong> {{ $page->slug }}
                            </div>
                            <div class="truncate sm:whitespace-normal items-center mt-3">
                                <strong>Контент</strong><br>
                                @php echo nl2br(htmlspecialchars($page->content)) @endphp
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex mt-10">
        <a href="{{ route('admin.page.edit', ['page' => $page->id]) }}"
            class="btn btn-success">
            Редактировать страницу
        </a>
        <form method="post" onsubmit="return confirm('Удалить эту страницу?')"
                action="{{ route('admin.page.destroy', ['page' => $page->id]) }}" style="margin-bottom: 0; margin-left: 10px">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">
                Удалить страницу
            </button>
        </form>
    </div>
@endsection


