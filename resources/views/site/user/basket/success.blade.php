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
                    <span @if ($status[$order->status] == 'Оплачен') style="color: green" @endif>{{ $status[$order->status] }}</span>
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

                @if ($order->status == 0)

                <form action="{{ route('basket.fast-payment') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $order->id }}">
                    <input type="hidden" name="slug" value="{{ $order->slug }}">
                    <input type="hidden" name="amount" value="{{ $order->amount }}">
                    <input type="hidden" name="email" value="{{ $order->email }}">

                    @if (auth()->user()->balance / 100 >= $order->amount)
                    <button class="btn-main mt-4 float-end"><span>Оплатить</span></button>
                    @else
                    Недостаточно средств на балансе
                    @endif
                </form>

                @endif
            </div>



            <div class="col-lg-4 mb30">
                {{-- @if (isset($resp_pay['payment_status']))
                    @if ($resp_pay['payment_status'] == 'finished')
                        <div class="alert alert-success">
                            Заказ успешно оплачен
                        </div>
                    @else
                        <div class="alert alert-warning">
                            Ожидание оплаты
                        </div>
                    @endif
                @endif --}}
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

                <div class="box-url blue mt-3">
                    <h4 class="mb-3">Связь с продавцом</h4>
                    
                    <div class="box-url-socials mt-4">
                        @if ($order->user->telegram)
                        <a class="box-url-social" href="https://t.me/{{ $order->user->telegram }}" target="_blank">
                            <i class="fa fa-telegram"></i>
                            <span class="cont">{{ $order->user->telegram }}</span>
                        </a>
                        @endif

                        @if ($order->user->phone)
                        <a class="box-url-social" href="tel:{{ $order->user->phone }}">
                            <i class="fa fa-phone"></i>
                            <span class="cont">{{ $order->user->phone }}</span>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
