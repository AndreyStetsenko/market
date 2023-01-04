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
                    <h1>Поиск по каталогу</h1>
                    @else
                    <h1>По вашему запросу ни чего не найдено</h1>
                    @endif
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

        <div class="spacer-single"></div>

        <div class="row wow fadeIn">
            <div class="col-lg-12">
                <h2 class="style-2">{{ $search ?? 'пусто' }}</h2>
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
