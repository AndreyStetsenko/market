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
                            @foreach($collections as $collection)
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="nft_coll style-2">
                                    <div class="nft_wrap">
                                        <a href="{{ route('user.personal.collection', $collection->id) }}">
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
</section>

@endsection