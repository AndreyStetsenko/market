@extends('site.layout.main')

@section('content')

<div id="top"></div>
    <section id="section-hero" aria-label="section" class="pt20 pb20 vh-100" data-bgimage="url({{ asset('site/images/background/8.jpg') }}) bottom">
        <div id="particles-js"></div>
        <div class="v-center">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="spacer-single"></div>
                        <h6 class="wow fadeInUp" data-wow-delay=".5s"><span class="text-uppercase id-color-2">HashMarket</span></h6>
                        <div class="spacer-10"></div>
                        <h1 class="wow fadeInUp" data-wow-delay=".75s">Создавай и продавай свою продукцию</h1>
                        <p class="wow fadeInUp lead" data-wow-delay="1s">
                        Маркетпоейс в котором ты можешь продать любой свой продукт и заработать на этом!</p>
                        <div class="spacer-10"></div>
                        @guest
                            <a href="{{ route('user.login') }}" class="btn-main wow fadeInUp lead" data-wow-delay="1.25s">Начать</a>
                        @else
                            <a href="{{ route('user.create.option') }}" class="btn-main wow fadeInUp lead" data-wow-delay="1.25s">Начать</a>
                        @endif
                        <div class="row">
                            <div class="spacer-single"></div>
                            <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-4 wow fadeInRight mb30" data-wow-delay="1.1s">
                                        <div class="de_count text-left">
                                            <h3><span>{{ count($collections) }}</span></h3>
                                            <h5 class="id-color">Коллекций</h5>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-4 wow fadeInRight mb30" data-wow-delay="1.4s">
                                        <div class="de_count text-left">
                                            <h3>{{ count($users) }}</h3>
                                            <h5 class="id-color">Пользователей</h5>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-4 wow fadeInRight mb30" data-wow-delay="1.7s">
                                        <div class="de_count text-left">
                                            <h3>{{ $count_prod }}</h3>
                                            <h5 class="id-color">Товаров</h5>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-6 xs-hide">
                        <img src="{{ asset('site/images/misc/women-with-vr.png') }}" class="img-fluid wow fadeInUp" data-wow-delay=".75s" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="section-collections" class="pt30 pb30">
        <div class="container">

                    @if($new->count())
                    <div class="row wow fadeIn"> 
                        <div class="col-lg-12">
                            <h2 class="style-2">Новые товары</h2>
                        </div>

                        <div id="items-carousel" class="owl-carousel wow fadeIn">
                        @foreach($new as $item)
                            @include('site.catalog.part.product', ['product' => $item])
                        @endforeach
                        </div>                                
                    </div>
                    @endif

                    <div class="spacer-single"></div>

                    <div class="row">
                        <div class="col-lg-12">
                            <h2 class="style-2">Коллекции</h2>
                        </div>
                        <div id="collection-carousel-alt" class="owl-carousel wow fadeIn">

                            @foreach ($collections as $collection)
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
                                    {{-- <span>ERC-192</span> --}}
                                </div>
                            </div>
                            @endforeach
                            
                        </div>
                    </div>

                </div>
    </section>

    <section id="section-text" class="no-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="style-2">Начни продавать уже сейчас</h2>
                </div>

                <div class="col-lg-4 col-md-6 mb-sm-30">
                    <div class="feature-box f-boxed style-3">
                        <i class="wow fadeInUp bg-color-2 i-boxed icon_wallet"></i>
                        <div class="text">
                            <h4 class="wow fadeInUp">Зарегистрируйся</h4>
                            <p class="wow fadeInUp" data-wow-delay=".25s">Регистрация проходит в пару кликов, настрой свой аккаунт и вперед!</p>
                        </div>
                        <i class="wm icon_wallet"></i>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-sm-30">
                    <div class="feature-box f-boxed style-3">
                        <i class="wow fadeInUp bg-color-2 i-boxed icon_cloud-upload_alt"></i>
                        <div class="text">
                            <h4 class="wow fadeInUp">Добавь свою продукцию</h4>
                            <p class="wow fadeInUp" data-wow-delay=".25s">У нас очень простая система продаж и добавления продукции</p>
                        </div>
                        <i class="wm icon_cloud-upload_alt"></i>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-sm-30">
                    <div class="feature-box f-boxed style-3">
                        <i class="wow fadeInUp bg-color-2 i-boxed icon_tags_alt"></i>
                        <div class="text">
                            <h4 class="wow fadeInUp">Начни продавать</h4>
                            <p class="wow fadeInUp" data-wow-delay=".25s">Выставляй свою продукцию на продажу, приглашай друзей и зарабатывай деньги!</p>
                        </div>
                        <i class="wm icon_tags_alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection