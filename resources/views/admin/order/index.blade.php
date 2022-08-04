@extends('admin.layout.side-menu')

{{ $title = 'Все заказы' }}

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
                    <th class="whitespace-nowrap">№</th>
                    <th class="whitespace-nowrap">Дата и время</th>
                    <th class="whitespace-nowrap">Статус</th>
                    <th class="whitespace-nowrap">Покупатель</th>
                    <th class="whitespace-nowrap">Адрес почты</th>
                    <th class="whitespace-nowrap">Номер телефона</th>
                    <th class="whitespace-nowrap">Пользователь</th>
                    <th class="whitespace-nowrap">Просмотр</th>
                    <th class="whitespace-nowrap">Изменить</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr class="intro-x">
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            @if ($order->status == 0)
                                <span class="text-warning">{{ $statuses[$order->status] }}</span>
                            @elseif (in_array($order->status, [1,2,3]))
                                <span class="text-success">{{ $statuses[$order->status] }}</span>
                            @else
                                {{ $statuses[$order->status] }}
                            @endif
                        </td>
                        <td>{{ $order->name }}</td>
                        <td><a href="mailto:{{ $order->email }}">{{ $order->email }}</a></td>
                        <td>{{ $order->phone }}</td>
                        <td>
                            @isset($order->user)
                                {{ $order->user->name }}
                            @endisset
                        </td>
                        <td>
                            <a href="{{ route('admin.order.show', ['order' => $order->id]) }}">
                                <i data-feather="eye" class="block mx-auto"></i>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.order.edit', ['order' => $order->id]) }}">
                                <i data-feather="edit" class="block mx-auto"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $orders->links() }}
@endsection
