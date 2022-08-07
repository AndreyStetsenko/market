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
                                    <span id="wallet" class="profile_wallet">{{ $user->wallet->first()->wallet }}</span>
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
                                @foreach($products as $item)
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                    @include('site.catalog.part.product', ['product' => $item])
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="tab-2">
                            <div class="row">

                                @foreach($collections as $item)
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                    @include('site.catalog.part.collection', ['collection' => $item])
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