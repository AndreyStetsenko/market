@extends('site.layout.main')

@section('content')
<div id="top"></div>
            
<!-- section begin -->
<section id="subheader">
    <div class="center-y relative text-center">
        <div class="container">
            <div class="row">
                
                <div class="col-md-12 text-center">
                    <h1>Заказ #{{ $order->id }}</h1>
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
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ $item->name }}</td>
                            <td>{{ number_format($item->price, 2, '.', '') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->cost, 2, '.', '') }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <th>Итого</th>
                            <td>{{ number_format($order->amount, 2, '.', '') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-1"></div>

            <div class="col-lg-3 mb30">
                <a class="box-url" href="03_grey-login.html">
                    <span class="box-url-label">Most Popular</span>
                    <img src="images/wallet/1.png" alt="" class="mb20">
                    <h4>Metamask</h4>
                    <p>Start exploring blockchain applications in seconds.  Trusted by over 1 million users worldwide.</p>
                </a>
            </div>

        </div>
    </div>
</section>
    <h1>Заказ размещен</h1>

    <p>Ваш заказ успешно размещен. Наш менеджер скоро свяжется с Вами для уточнения деталей.</p>

    <h2>Ваш заказ</h2>
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

    <h2>Ваши данные</h2>
    <p>Имя, фамилия: {{ $order->name }}</p>
    <p>Адрес почты: <a href="mailto:{{ $order->email }}">{{ $order->email }}</a></p>
    <p>Номер телефона: {{ $order->phone }}</p>
    <p>Адрес доставки: {{ $order->address }}</p>
    @isset ($order->comment)
        <p>Комментарий: {{ $order->comment }}</p>
    @endisset
@endsection
