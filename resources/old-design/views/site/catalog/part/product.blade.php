<div>
    <div class="nft__item style-2">
        <div class="author_list_pp">
            <a href="{{ route('user.profile', $product->creator->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Автор: {{ $product->creator->name }}">                                    
                @if ($product->creator->avatar != 'avatar.jpeg')
                    @php($url = url('storage/catalog/avatar/image/' . $product->creator->avatar))
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
                @if ($product->attachmentable)
                    @php($url = url('storage/catalog/product/source/' . $product->attachmentable[0]->attachment->name))
                    <img src="{{ $url }}" id="get_file_2" class="lazy lazy nft__item_preview" alt="">
                @else
                    <img src="{{ asset('site/images/collections/coll-item-3.jpg') }}" id="get_file_2" class="lazy lazy nft__item_preview" alt="">
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
                @if ($resell ?? '')
                    {{ $resell_product->price }} USD
                    @if ($resell_product->count ?? '')
                        <small class="d-block">Total: {{ $resell_product->price * $resell_product->count }} USD</small>
                    @endif
                @else
                    {{ $product->price }} USD
                    @if ($count ?? '')
                        <small class="d-block">Total: {{ $product->price * $count }} USD</small>
                    @endif
                @endif
            </div>
            <div class="nft__item_action">
                <a href="{{ route('catalog.product', ['product' => $product->slug]) }}">Смотреть</a>
            </div>
            @if ($sell ?? '')
            <div class="nft__item_action">
                {{-- <a href="{{ route('user.personal.sell-product.create', $product->slug) }}">На продажу</a> --}}
                <a data-bs-toggle="modal" href="#modalToSell" role="button" data-product-id="{{ $product->id }}" class="get_product_mini_info">На продажу</a>
            </div>
            @endif
            @if ($resell ?? '')
            <div class="nft__item_action">
                <a href="{{ route('user.personal.sell-product.edit', $product->slug) }}">Редактировать</a>
            </div>
            @endif
        </div> 
    </div>
</div>