@extends('admin.layout.side-menu')

{{ $title = 'Вывод денег пользователей' }}

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('breadcrumb-title')
{{ $title }}
@endsection

@section('subcontent')

<h2 class="intro-y text-lg font-medium mt-10">{{ $title }}</h2>

<div class="intro-y col-span-12 overflow-auto lg:overflow-visible mt-5">
    <table class="table table-report -mt-2">
        <thead>
            <tr>
                <th class="whitespace-nowrap">Имя</th>
                <th class="whitespace-nowrap">Метод</th>
                <th class="whitespace-nowrap">Адрес</th>
                <th class="whitespace-nowrap">Сумма</th>
                <th class="whitespace-nowrap"><i data-feather="edit" class="block mx-auto"></i></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($withdraws as $item)
                <tr class="intro-x">
                    <td>{{ $item->user()->name }}</td>
                    <td>{{ $item->method }}</td>
                    <td>{{ $item->address }}</td>
                    <td>{{ $item->amount / 100 }} {{ json_decode($item->wallet()->meta)->currency }}</td>
                    <td>
                        <div style="display:flex;justify-content:center">
                            <form action="{{ route('admin.withdraw.success') }}" method="post" style="margin-bottom: 0">
                                @csrf
                
                                <input type="hidden" value="{{ $item->id }}" name="id">
                                <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                                    <i data-feather="check-square" class="w-4 h-4 mr-1"></i>
                                </button>
                            </form>

                            {{-- <form action="" method="post" style="margin-bottom:0;margin-left:5px">
                                @csrf
                
                                <input type="hidden" value="{{ $item->id }}" name="id">
                                <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                                    <i data-feather="trash-2" class="w-4 h-4 mr-1"></i>
                                </button>
                            </form> --}}
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $withdraws->links() }}
@endsection