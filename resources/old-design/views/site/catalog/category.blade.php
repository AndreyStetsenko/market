@extends('site.layout.main')

@section('content')

<div id="top"></div>
            
<!-- section begin -->
<section id="subheader">
        <div class="center-y relative text-center">
            <div class="container">
                <div class="row">
                    
                    <div class="col-md-12 text-center">
                        <h1>{{ $category->name }}</h1>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
</section>
<!-- section close -->


<!-- section begin -->
<section aria-label="section">
    <div class="container">

        @if (count($category->children) > 0)
        <div class="row">
            <div class="col-lg-12">
                <h2 class="style-2">Категории</h2>
            </div>
            <div id="collection-carousel-alt" class="owl-carousel wow fadeIn">

                @foreach ($category->children as $child)
                    @include('site.catalog.part.category', ['category' => $child])
                @endforeach
                
            </div>
        </div>

        <div class="spacer-single"></div>
        @endif

        <div class="row wow fadeIn">
            <div class="col-lg-12">

                <form method="get"
                    action="{{ route('catalog.category', ['category' => $category->slug]) }}">
                    <div class="items_filter d-flex form-border">

                        @include('site.catalog.part.filter')
                        <a href="{{ route('catalog.category', ['category' => $category->slug]) }}"
                            class="btn-main btn-sm h100 d-flex align-items-center ms-3">Сбросить</a>

                    </div>
                </form>

            </div>                     
            <!-- nft item begin -->
            @foreach($products as $item)
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                @include('site.catalog.part.product', ['product' => $item])
            </div>
            @endforeach           

            <div class="col-md-12 text-center mt-5">
                {{ $products->links('site.dop.paginate') }}
            </div>  
        </div>
    </div>
</section>

@endsection