@extends('site.layout.main')

@section('content')

<div id="top"></div>

<!-- section begin -->
<section id="subheader">
    <div class="center-y relative text-center">
        <div class="container">
            <div class="row">
                
                <div class="col-md-12 text-center">
                    <h1>Оформить заказ</h1>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>
<!-- section close -->

<!-- section begin -->
<section id="section-main" aria-label="section">
<div class="container">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-6 offset-lg-2">

            @if ($profiles && $profiles->count())
                @include('site.user.basket.select', ['current' => $profile->id ?? 0])
            @endif

            <form class="form-border" method="post" action="{{ route('basket.saveorder') }}" id="checkout">
            @csrf
            <div class="de_tab tab_simple">
                
                <div class="de_tab_content">
                    <div class="tab-1">
                        <div class="row wow fadeIn">
                            <div class="col-lg-8 mb-sm-20">
                                    <div class="field-set">

                                        <div class="spacer-40"></div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Имя, Фамилия"
                                                   required maxlength="255" value="{{ old('name') ?? $profile->name ?? '' }}">
                                            <div class="input-error"></div>
                                        </div>

                                        <div class="spacer-20"></div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" name="email" id="email" placeholder="Адрес почты"
                                                   required maxlength="255" value="{{ old('email') ?? $profile->email ?? '' }}">
                                            <div class="input-error"></div>
                                        </div>

                                        <div class="spacer-20"></div>
                                        
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Номер телефона"
                                                   required maxlength="255" value="{{ old('phone') ?? $profile->phone ?? '' }}">
                                            <div class="input-error"></div>
                                        </div>

                                        <div class="spacer-20"></div>
                                        
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="address" id="address" placeholder="Адрес доставки"
                                                   required maxlength="255" value="{{ old('address') ?? $profile->address ?? '' }}">
                                            <div class="input-error"></div>
                                        </div>

                                        <div class="spacer-20"></div>
                                        
                                        <div class="form-group">
                                            <textarea class="form-control" name="comment" id="comment" placeholder="Комментарий"
                                                      maxlength="255" rows="2">{{ old('comment') ?? $profile->comment ?? '' }}</textarea>
                                                <div class="input-error"></div>
                                        </div>
                                        
                                        <div class="spacer-20"></div>

                                        <div class="form-group">
                                            <button type="submit" class="btn-main w-100">Оформить</button>
                                        </div>

                                    </div>
                            </div>                                    
                        </div>
                    </div>

                </div>
            </div>

            </form>
        </div>
    </div>
</div>
</section>
@endsection
