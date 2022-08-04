@extends('admin.layout.side-menu')

{{ $title = 'Просмотр заказа' }}

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('breadcrumb-title')
{{ $title }}
@endsection

@section('subcontent')
    <h2 class="intro-y text-lg font-medium mt-10">Данные по заказу № {{ $order->id }}</h2>

    <h3 class="intro-y text-sm font-medium mt-5">
        Статус заказа:
        @if ($order->status == 0)
            <span class="text-warning">{{ $statuses[$order->status] }}</span>
        @elseif (in_array($order->status, [1,2,3]))
            <span class="text-success">{{ $statuses[$order->status] }}</span>
        @else
            {{ $statuses[$order->status] }}
        @endif
    </h3>

    <div class="grid grid-cols-12 gap-6 mt-5">

        <div class="intro-y col-span-12 lg:col-span-6">
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                    <h2 class="font-medium text-base mr-auto">Данные покупателя</h2>
                </div>
                <div class="p-5" id="basic-table">
                    <div class="preview">
                        <div class="overflow-x-auto">

                            <div class="flex flex-col justify-center items-center lg:items-start">
                                <div class="truncate sm:whitespace-normal flex items-center">
                                    Имя, фамилия: <b class="ml-2">{{ $order->name }}</b>
                                </div>
                                <div class="truncate sm:whitespace-normal flex items-center mt-3">
                                    Адрес почты: <b class="ml-2"><a href="mailto:{{ $order->email }}">{{ $order->email }}</a></b>
                                </div>
                                <div class="truncate sm:whitespace-normal flex items-center mt-3">
                                    Номер телефона: <b class="ml-2">{{ $order->phone }}</b>
                                </div>
                                <div class="truncate sm:whitespace-normal flex items-center mt-3">
                                    Адрес доставки: <b class="ml-2">{{ $order->address }}</b>
                                </div>
                                @isset ($order->comment)
                                <div class="truncate sm:whitespace-normal flex items-center mt-3">
                                    Комментарий: <b class="ml-2">{{ $order->comment }}</b>
                                </div>
                                @endisset
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="intro-y col-span-12 lg:col-span-6">
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                    <h2 class="font-medium text-base mr-auto">Состав заказа</h2>
                </div>
                <div class="p-5" id="basic-table">
                    <div class="preview">
                        <div class="overflow-x-auto">
                            <table class="table table-bordered">
                                <tr>
                                    <th>№</th>
                                    <th>Наименование</th>
                                    <th>Цена</th>
                                    <th>Кол-во</th>
                                    <th>Стоимость</th>
                                </tr>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ number_format($item->price, 2, '.', '') }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->cost, 2, '.', '') }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th colspan="4" class="text-right">Итого</th>
                                    <th>{{ number_format($order->amount, 2, '.', '') }}</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
