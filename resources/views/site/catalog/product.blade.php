@extends('site.layout.main')

@section('content')

<div id="top"></div>

<section id="nft-item-details" aria-label="section" class="sm-mt-0">
    <div class="container">
        <div class="row g-5">
            <div class="col-md-6 text-center">
                <div class="nft-image-wrapper">
                    @if ($product->image)
                        @php($url = url('storage/catalog/product/source/' . $product->image))
                        <img src="{{ $url }}" alt="" class="img-fluid img-rounded mb-sm-30">
                    @else
                        <img src="https://via.placeholder.com/600x300" alt="" class="img-fluid img-rounded mb-sm-30">
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="item_info">
                    {{-- Auctions ends in <div class="de_countdown" data-year="2022" data-month="6" data-day="16" data-hour="8"></div> --}}
                    <h2>{{ $product->name }}</h2>
                    <div class="item_info_counts">
                        @if ($product->collection->id ?? '')
                        <div class="item_info_type">
                            <a href="{{ route('collection.show', $product->collection->id) }}" class="text-white">
                                {{ $product->collection->name }}
                            </a>
                        </div>
                        @endif
                        <div class="item_info_type">
                            <a href="{{ route('catalog.category', $product->category->slug) }}" class="text-white">
                                {{ $product->category->name }}
                            </a>
                        </div>
                        @if($product->new)
                            <div class="item_info_type">Новинка</div>
                        @endif
                        @if($product->hit)
                            <div class="item_info_type">Лидер продаж</div>
                        @endif
                        @if($product->sale)
                            <div class="item_info_type">Распродажа</div>
                        @endif
                    </div>
                    {!! $product->content !!}

                    <div class="d-flex flex-row mt-3">
                        <div class="mr40">
                            <h6>Автор</h6>
                            <div class="item_author">                                    
                                <div class="author_list_pp">
                                    <a href="{{ route('user.profile', $product->creator->id) }}">
                                        @if ($product->creator->avatar != 'avatar.jpeg')
                                            @php($url = url('storage/catalog/avatar/image/' . $product->creator->avatar))
                                            <img src="{{ $url }}" class="lazy img-fluid" alt="" style="width: 50px;height: 50px !important;object-fit: cover;">
                                        @else
                                            <img src="{{ asset( 'img/' . $product->creator->avatar ) }}" class="lazy img-fluid" alt="">
                                        @endif
                                    </a>
                                </div>                                    
                                <div class="author_list_info">
                                    <a href="{{ route('user.profile', $product->creator->id) }}">{{ $product->creator->name }}</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="spacer-40"></div>

                    <form action="{{ route('basket.add', ['id' => $product->id]) }}"
                        method="post" class="form-inline add-to-basket form-border">
                        @csrf

                        <div class="d-flex">
                            <div>
                                <h6>Цена</h6>
                                <div class="nft-item-price"><span>{{ number_format($product->price, 2, '.', '') }} $</span></div>
                            </div>
                            <div class="ms-5">
                                <h6>Количество</h6>
                                <input type="text" name="quantity" id="input-quantity" value="1"
                                    class="form-control mx-2 w-25"
                                    style="height: 34px; text-align: center; margin-top: -5px; margin-left: 0 !important;">
                            </div>
                        </div>

                        <button type="submit" class="btn-main btn-lg d-block">
                            Добавить в корзину
                        </button>

                        @if ( $product_basket )
                        <button onclick="window.location.href = '{{ route('basket.index') }}'" type="button" class="btn-main btn-lg d-block mt-3">
                            Перейти в корзину
                        </button>
                        @endif
                    </form>
                    
                </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>

@if (count($products) > 0)
<section id="section-collections" class="pt30 pb30">
    <div class="container">

        <div class="row wow fadeIn"> 
            <div class="col-lg-12">
                <h2 class="style-2">Похожие товары</h2>
            </div>

            <div id="items-carousel" class="owl-carousel wow fadeIn">
            @foreach($products as $item)
                @include('site.catalog.part.product', ['product' => $item])
            @endforeach
            </div>                                
        </div>

    </div>
</section>
@endif

@endsection