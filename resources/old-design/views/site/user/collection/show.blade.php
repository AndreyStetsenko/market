@extends('site.layout.main')

@section('content')

<div id="top"></div>
            
<!-- section begin -->
<section id="profile_banner" aria-label="section" class="text-light" data-bgimage="url({{ asset('site/images/background/5.jpg') }}) center">
        
</section>
<!-- section close -->


<section aria-label="section" class="d_coll no-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="d_profile">
                        <div class="profile_avatar">
                            <div class="d_profile_img">
                                @if ($collection->image != 'avatar.jpeg')
                                    @php($url = url('storage/catalog/collection/source/' . $collection->image))
                                    <img src="{{ $url }}" class="lazy img-fluid" alt="{{ $collection->name }}" style="height: 150px;object-fit: cover">
                                @else
                                    <img src="https://via.placeholder.com/300x150" class="lazy img-fluid" alt="">
                                @endif
                                <i class="fa fa-check"></i>
                            </div>
                            
                            <div class="profile_name">
                                <h4>
                                    {{ $collection->name }}
                                    <div class="clearfix"></div>
                                    {{-- <span id="wallet" class="profile_wallet">{{ $collection->user->wallet->where('currency', 'usdt')->first()->wallet ?? '' }}</span> --}}
                                    {{-- <button id="btn_copy" title="Copy Text">Copy</button> --}}
                                </h4>
                            </div>
                        </div>

                </div>
            </div>

            <div class="col-md-12">
                <div class="row">

                    @foreach($collection->products as $item)
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        @include('site.catalog.part.product', ['product' => $item])
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>

@endsection