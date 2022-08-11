@extends('site.layout.main')

@section('content')

<div id="top"></div>

<section aria-label="section">
    <div class="container">
        <div class="row">
            @include('site.user.personal.part.head')

            <div class="col-md-12">
                <div class="de_tab tab_simple">

                    @include('site.user.personal.part.nav')
                    
                    <div class="de_tab_content">
                        
                        <table class="table de-table table-rank">
                            <thead>
                                <tr>
                                    <th scope="col">Order ID</th>
                                    <th scope="col">Товаров</th>
                                    <th scope="col">Сумма</th>
                                    <th scope="col">Статус</th>
                                    <th scope="col">Дата</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                <tr>
                                    <td scope="row">
                                        {{ mb_substr($order->slug, 0, 10) . '...' }}
                                    </td>
                                    <td>{{ count($order->items) }}</td>
                                    <td>{{ $order->amount }} USD</td>
                                    @if ($order->status == 0)
                                        <td class="text-warning">{{ $statuses[$order->status] }}</td>
                                    @elseif (in_array($order->status, [1,2,3]))
                                        <td class="text-warning">{{ $statuses[$order->status] }}</td>
                                    @elseif ($order->status == 5)
                                        <td class="text-danger">{{ $statuses[$order->status] }}</td>
                                    @else
                                        <td class="d-plus">{{ $statuses[$order->status] }}</td>
                                    @endif
                                    <td><span class="text-muted">{{ date('H:m', strtotime($order->created_at)) }}</span> {{ date('d M Y', strtotime($order->created_at)) }}</td>
                                    <td><a href="{{ route('basket.success', $order->slug) }}"><i class="fa fa-eye"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-5">
                            {{ $orders->links('site.dop.paginate') }}
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>

@endsection