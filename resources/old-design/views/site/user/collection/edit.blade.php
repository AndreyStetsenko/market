@extends('site.layout.main')

@section('content')

<div id="top"></div>
            
<!-- section begin -->
<section id="subheader">
        <div class="center-y relative text-center">
            <div class="container">
                <div class="row">
                    
                    <div class="col-md-12 text-center">
                        <h1>Обновить коллекцию</h1>
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
        <div class="row wow fadeIn">
            <div class="col-lg-7 offset-lg-1">
                <form id="product-create" class="form-border" method="post" action="{{ route('user.collection.update', $collection->id) }}" 
                        enctype="multipart/form-data"
                        data-formtype="collection" 
                        data-formaction="edit">
                    @csrf

                    <div class="field-set">
                        <div class="form-group">
                            <h5>Загрузить изображение *</h5>
                            <ul id="file_name" class="text-muted fs-6 mt-2 mb-2 d-block list">PNG, JPG, JPEG</ul>
                            <button type="button" class="btn-load-img" id="load-img">Загрузить изображение</button>
                            <div class="input-error input-error-image"></div>
                            <input type="file" class="form-control" id="image" 
                                name="image" accept="image/png, image/jpeg, image/jpg image/webp" required multiple style="opacity: 0; margin: 0; padding: 0; height: 0;">
                        </div>

                        <div class="spacer-40"></div>

                        <div class="form-group">
                            <h5>Название</h5>
                            <input type="text" name="name" id="name" class="form-control" placeholder="e.g. 'Crypto Funk"
                                    required maxlength="100" value="{{ old('name') ?? $collection->name ?? '' }}" />
                            <div class="input-error"></div>
                        </div>

                        <div class="spacer-20"></div>

                        <div class="form-group">
                            <h5>Описание</h5>
                            <textarea data-autoresize name="content" id="item_desc" class="form-control" placeholder="e.g. 'This is very limited item'">{!! old('content') ?? $collection->description ?? '' !!}</textarea>
                            <div class="input-error"></div>
                        </div>

                        <div class="spacer-20"></div>

                        <input type="submit" id="submit" class="btn-main" value="Обновить">
                        <div class="spacer-single"></div>
                    </div>
                </form>
            </div>

            <div class="col-lg-3 col-sm-6 col-xs-12">
                <h5>Предпросмотр</h5>

                <div class="nft_coll style-2" id="product-create-preview">
                    <div class="nft_wrap">
                        <a href="{{ route('user.profile', auth()->user()->id) }}" onclick="event.preventDefault()">
                            @if ($collection->image != 'avatar.jpeg')
                                @php($url = url('storage/catalog/collection/source/' . $collection->image))
                                <img src="{{ $url }}" id="get_file_2" class="lazy img-fluid" alt="">
                            @else
                                <img src="{{ asset('site/images/collections/coll-item-3.jpg') }}" id="get_file_2" class="lazy img-fluid" alt="">
                            @endif
                        </a>
                    </div>
                    <div class="nft_coll_pp">
                        <a href="{{ route('user.profile', auth()->user()->id) }}" onclick="event.preventDefault()">
                            @if (auth()->user()->avatar != 'avatar.jpeg')
                                @php($url = url('storage/catalog/avatar/image/' . auth()->user()->avatar))
                                <img src="{{ $url }}" class="lazy img-fluid" alt="" style="width: 50px;height: 50px !important;object-fit: cover;">
                            @else
                                <img src="{{ asset( 'img/' . auth()->user()->avatar ) }}" class="lazy img-fluid" alt="">
                            @endif
                        </a>
                        <i class="fa fa-check"></i>
                    </div>
                    <div class="nft_coll_info">
                        <a href="{{ route('user.profile', auth()->user()->id) }}" onclick="event.preventDefault()"><h4 class="product-preview-name">{{ $collection->name }}</h4></a>
                        {{-- <span>ERC-192</span> --}}
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

@endsection