@extends('site.layout.main')

@section('content')

<div id="top"></div>
            
<!-- section begin -->
<section id="subheader">
    <div class="center-y relative text-center">
        <div class="container">
            <div class="row">
                
                <div class="col-md-12 text-center">
                    @if (count($products))
                    <h1>Корзина</h1>
                    @else
                    <h1>Ваша корзина пуста</h1>
                    @endif
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

            @if (count($products))
            <div class="col-md-8">
                <ul class="activity-list">
                    @foreach($products as $product)
                    <li class="act_like">
                        <a href="{{ route('catalog.product', ['product' => $product->slug]) }}">
                            @if ($product->image != 'avatar.jpeg')
                                @php($url = url('storage/catalog/product/source/' . $product->image))
                                <img src="{{ $url }}" class="lazy" alt="">
                            @else
                                <img src="{{ asset('site/images/collections/coll-item-3.jpg') }}" id="get_file_2" class="lazy" alt="">
                            @endif
                        </a>
                        <div class="act_list_text">
                            <a href="{{ route('catalog.product', ['product' => $product->slug]) }}">
                                <h4>{{ $product->name }}</h4>
                            </a>
                            Цена: {{ $product->price }} USD <br>
                            <span class="act_list_date">
                                Количество: {{ $product->pivot->quantity }}
                            </span>
                            Стоимость: {{ number_format($product->price * $product->pivot->quantity, 2, '.', '') }} USD
                        </div>

                        <div class="actions">

                            <div class="count">
                                <form action="{{ route('basket.minus', ['id' => $product->id]) }}"
                                    method="post" class="d-inline">
                                  @csrf
                                  <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                                      <i class="text-white fa fa-minus-square"></i>
                                  </button>
                              </form>
                              <span class="mx-1">{{ $product->pivot->quantity }}</span>
                              <form action="{{ route('basket.plus', ['id' => $product->id]) }}"
                                    method="post" class="d-inline">
                                  @csrf
                                  <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                                      <i class="text-white fa fa-plus-square"></i>
                                  </button>
                              </form>
                            </div>

                            <div class="remove">
                                <form action="{{ route('basket.remove', ['id' => $product->id]) }}"
                                    method="post">
                                  @csrf
                                  <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                                      <i class="fa fa-trash text-danger"></i>
                                  </button>
                              </form>
                            </div>

                        </div>

                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-1"></div>

            <div class="col-md-3">
                <div class="mb-2">
                    Итого
                    <span>{{ number_format($amount, 2, '.', '') }} USD</span>
                </div>

                <a href="{{ route('basket.checkout') }}" class="btn-main btn-lg btn-success mb-3">
                    Оформить заказ
                </a>
                
                <form action="{{ route('basket.clear') }}" method="post" class="text-right">
                    @csrf
                    <button type="submit" class="btn-main btn-xl btn-danger mb-4 mt-0">
                        Очистить корзину
                    </button>
                </form>
            </div>
            @endif

        </div>
    </div>
</section>
@endsection
