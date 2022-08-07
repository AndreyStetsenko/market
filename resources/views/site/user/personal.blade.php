@extends('site.layout.main')

@section('content')

<div id="top"></div>

<section aria-label="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="d_profile de-flex">
                    <div class="de-flex-col">
                        <div class="profile_avatar">
                            @if ($user->avatar != 'avatar.jpeg')
                                @php($url = url('storage/catalog/avatar/image/' . $user->avatar))
                                <img src="{{ $url }}" class="img-fluid" alt="" style="width: 150px;height: 150px !important;object-fit: cover;">
                            @else
                                <img src="{{ asset( 'img/' . $user->avatar ) }}" class="img-fluid" alt="">
                            @endif
                            <i class="fa fa-check"></i>
                            <div class="profile_name">
                                <h4>
                                    {{ $user->name }}
                                    <span class="profile_username">{{ $user->username != null ? '@' . $user->username : '' }}</span>
                                    <span id="wallet" class="profile_wallet">{{ $user->wallet->first()->wallet ?? '' }}</span>
                                    <button id="btn_copy" title="Copy Text">Copy</button>
                                </h4>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-12">
                <div class="de_tab tab_simple">

                    <ul class="de_nav">
                        <li class="active"><span>Все товары</span></li>
                        <li><span>Коллекции</span></li>
                    </ul>
                    
                    <div class="de_tab_content">
                        
                        <div class="tab-1">
                            <div class="row">
                                @foreach($products as $product)
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                    
                                    <div>
                                        <div class="nft__item style-2">
                                            <div class="author_list_pp">
                                                <a href="{{ route('user.profile', $product->creator->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Автор: {{ $product->creator->name }}">                                    
                                                    @if ($product->creator->avatar != 'avatar.jpeg')
                                                        @php($url = url('storage/catalog/avatar/source/' . $product->creator->avatar))
                                                        <img src="{{ $url }}" class="img-fluid" alt="" style="width: 45px;height: 45px !important;object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset( 'img/' . $product->creator->avatar ) }}" class="img-fluid" alt="">
                                                    @endif
                                                    <i class="fa fa-check"></i>
                                                </a>
                                            </div>
                                            <div class="nft__item_wrap">
                                                <div class="nft__item_extra">
                                                    <div class="nft__item_buttons">
                                                        <form action="{{ route('basket.add', ['id' => $product->id]) }}"
                                                                method="post" class="d-inline add-to-basket">
                                                            @csrf
                                                            <button type="submit">В корзину</button>
                                                        </form>
                                                        {{-- <div class="nft__item_share">
                                                            <h4>Share</h4>
                                                            <a href="https://www.facebook.com/sharer/sharer.php?u=https://gigaland.io" target="_blank"><i class="fa fa-facebook fa-lg"></i></a>
                                                            <a href="https://twitter.com/intent/tweet?url=https://gigaland.io" target="_blank"><i class="fa fa-twitter fa-lg"></i></a>
                                                            <a href="mailto:?subject=I wanted you to see this site&amp;body=Check out this site https://gigaland.io"><i class="fa fa-envelope fa-lg"></i></a>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                                <a href="{{ route('catalog.product', ['product' => $product->slug]) }}">
                                                    <div class="d-placeholder"></div>
                                                    @if ($product->image)
                                                        @php($url = url('storage/catalog/product/source/' . $product->image))
                                                        <img src="{{ $url }}" class="img-fluid lazy nft__item_preview" alt="">
                                                    @else
                                                        <img src="https://via.placeholder.com/300x150" class="img-fluid lazy nft__item_preview" alt="">
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="nft__item_info">
                                                <a href="{{ route('catalog.product', ['product' => $product->slug]) }}">
                                                    <h4>{{ $product->name }}</h4>
                                                </a>
                                                @if($product->new)
                                                    {{-- <span class="badge badge-info text-white">Новинка</span> --}}
                                                @endif
                                                @if($product->hit)
                                                    {{-- <span class="badge badge-danger">Лидер продаж</span> --}}
                                                @endif
                                                @if($product->sale)
                                                    {{-- <span class="badge badge-success">Распродажа</span> --}}
                                                @endif
                                                <div class="nft__item_click">
                                        <span></span>
                                    </div>
                                    <div class="nft__item_price">
                                                    {{ $product->price }} USD
                                                </div>
                                                <div class="nft__item_action">
                                                    <a href="{{ route('catalog.product', ['product' => $product->slug]) }}">Смотреть</a>
                                                </div>
                                                <div class="nft__item_action">
                                                    <a href="{{ route('user.product.edit', ['product' => $product->id]) }}">Редактировать</a>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>

                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="tab-2">
                            <div class="row">

                                @foreach($collections as $collection)
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                    <div class="nft_coll style-2">
                                        <div class="nft_wrap">
                                            <a href="{{ route('collection.show', $collection->id) }}">
                                                @if ($collection->image != 'avatar.jpeg')
                                                    @php($url = url('storage/catalog/collection/source/' . $collection->image))
                                                    <img src="{{ $url }}" class="lazy img-fluid" alt="">
                                                @else
                                                    <img src="https://via.placeholder.com/300x150" class="lazy img-fluid" alt="">
                                                @endif
                                            </a>
                                        </div>
                                        <div class="nft_coll_pp">
                                            <a href="{{ route('user.profile', $collection->user->id) }}">
                                                @if ($collection->user->avatar != 'avatar.jpeg')
                                                    @php($url = url('storage/catalog/avatar/image/' . $collection->user->avatar))
                                                    <img src="{{ $url }}" class="lazy pp-coll" alt="" style="width: 45px;height: 45px !important;object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('img/' . $collection->user->avatar) }}" class="lazy pp-coll" alt="" style="width: 45px;height: 45px !important;object-fit: cover;">
                                                @endif
                                            </a>
                                            <i class="fa fa-check"></i>
                                        </div>
                                        <div class="nft_coll_info">
                                            <a href="{{ route('collection.show', $collection->id) }}"><h4>{{ $collection->name }}</h4></a>
                                            <a href="{{ route('user.collection.edit', $collection->id) }}"><span>Редактировать</span></a>
                                            {{-- <span>ERC-192</span> --}}
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>

@endsection