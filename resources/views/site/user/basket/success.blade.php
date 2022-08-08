@extends('site.layout.main')

@section('content')
<div id="top"></div>
            
<!-- section begin -->
<section id="subheader">
    <div class="center-y relative text-center">
        <div class="container">
            <div class="row">
                
                <div class="col-md-12 text-center">
                    <h1>Заказ #{{ $order->id }}</h1><br>
                    <span>{{ $status[$order->status] }}</span>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>
<!-- section close -->


<section aria-label="section">
    <div class="container">
        <div class="row">

            <div class="col-md-8">
                <table class="table de-table table-rank">
                    <thead>
                        <tr>
                            <th scope="col">№</th>
                            <th scope="col">Наименование</th>
                            <th scope="col">Цена</th>
                            <th scope="col">Кол-во</th>
                            <th scope="col">Стоимость</th>
                        </tr>
                    </thead>
                    <tbody>
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
                            <td>Итого</td>
                            <td>{{ number_format($order->amount, 2, '.', '') }} USD</td>
                        </tr>
                    </tbody>
                </table>
            </div>



            <div class="col-lg-4 mb30">
                <div class="box-url mb-2">
                    <h4>Ваши данные</h4>
                    <p>Имя, фамилия: {{ $order->name }}</p>
                    <p>Адрес почты: <a href="mailto:{{ $order->email }}">{{ $order->email }}</a></p>
                    <p>Номер телефона: {{ $order->phone }}</p>
                    <p>Адрес доставки: {{ $order->address }}</p>
                    @isset ($order->comment)
                        <p>Комментарий: {{ $order->comment }}</p>
                    @endisset
                </div>
                
                @if ($order->status == 0)
                <a href="" class="btn-main mt-4 float-end"><span>Оплатить</span></a>
                @endif
            </div>

        </div>
    </div>
</section>
@endsection
