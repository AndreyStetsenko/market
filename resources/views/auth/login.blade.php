@extends('site.layout.main')

@section('content')
<div id="top"></div>
			
<section class="full-height relative no-top no-bottom vertical-center" data-bgimage="url({{ asset('site/images/background/6.jpg') }}) top" data-stellar-background-ratio=".5">
    <div class="overlay-gradient t50">
        <div class="center-y relative">
            <div class="container">
                <div class="row align-items-center">
                    
                    <div class="col-lg-4 offset-lg-4 wow fadeIn bg-color" data-wow-delay=".5s">
                        <div class="box-rounded padding40">
                            <h3 class="mb10 mb-3">Авторизация</h3>
                            <form name="contactForm" id='contact_form' class="form-border" method="POST" action="{{ route('user.login') }}">
                                @csrf

                                <div class="field-set">
                                    <input type='text' name='email' id='email' class="form-control" placeholder="Имя пользователя / Email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="field-set">
                                    <input type='password' name='password' id='password' class="form-control" placeholder="Пароль" required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="field-set mb-2">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                                
                                <div class="field-set">
                                    <input type='submit' id='send_message' value='Вход' class="btn btn-main btn-fullwidth color-2">
                                </div>
                                
                                <div class="clearfix"></div>
                                
                                <div class="spacer-single"></div>

                            <!-- social icons -->
                            <ul class="list s3">
                                <li><a href="{{ route('user.register') }}">Регистрация</a></li>
                                @if (Route::has('user.password.request'))
                                <li><a href="{{ route('user.password.request') }}">Восстановить пароль</a></li>
                                @endif
                            </ul>
                            <!-- social icons close -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
