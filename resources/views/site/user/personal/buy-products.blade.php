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
                        
                        <div class="row">
                            @foreach ($products as $item)
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 position-relative">
                                    <span class="p-count">{{ $item->count }}</span>
                                    @include('site.catalog.part.product', ['product' => $item->product, 'count' => $item->count])
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-5">
                            {{ $products->links('site.dop.paginate') }}
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    <style>
        .p-count {
            position: absolute;
            top: -8px;
            right: 1px;
            background: #27292d;
            border: 1px solid #3d3f42;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            z-index: 2;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 12px;
            box-shadow: 0 0 2px 2px rgba(0,0,0,0.2);
        }
    </style>
@endpush