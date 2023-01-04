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
                            @error('email')
                                <span class="alert alert-danger d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @error('password')
                                <span class="alert alert-danger d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <h3 class="mb10 mb-3">{{ __('Reset Password') }}</h3>
                            <form name="contactForm" id='contact_form' class="form-border" method="POST" action="{{ route('user.password.update') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">

                                <input type='hidden' name='email' id='email' class="form-control" placeholder="Имя пользователя / Email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                                <div class="field-set">
                                    <input type='password' name='password' id='password' class="form-control" placeholder="Пароль" required autocomplete="current-password">
                                </div>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <div class="field-set">
                                    <input type='password' name='password_confirmation' id='password-confirm' class="form-control" placeholder="Пароль" required autocomplete="current-password">
                                </div>
                                
                                <div class="field-set">
                                    <input type='submit' id='send_message' value='Сменить пароль' class="btn btn-main btn-fullwidth color-2">
                                </div>
                                
                                <div class="clearfix"></div>
                                
                                <div class="spacer-single"></div>
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
