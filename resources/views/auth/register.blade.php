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

                            @error('name')
                                <span class="alert alert-danger d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            @error('email')
                                <span class="alert alert-danger d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            @error('username')
                                <span class="alert alert-danger d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            @error('password')
                                <span class="alert alert-danger d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            @error('usepassword-confirmrname')
                                <span class="alert alert-danger d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <h3 class="mb10 mb-3">{{ __('Register') }}</h3>
                            <form name="contactForm" id='contact_form' class="form-border" method="POST" action="{{ route('user.register') }}">
                                @csrf

                                <div class="field-set">
                                    <input type='text' name='name' id='name' class="form-control" placeholder="Имя, фамилия" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                </div>

                                <div class="field-set">
                                    <input type='text' name='email' id='email' class="form-control" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                </div>

                                <div class="field-set">
                                    <input type='text' name='username' id='username' class="form-control" placeholder="Имя пользователя" value="{{ old('username') }}" required autocomplete="username" autofocus>
                                </div>

                                <div class="field-set">
                                    <input type='password' name='password' id='password' class="form-control" placeholder="Пароль" required autofocus>
                                </div>

                                <div class="field-set">
                                    <input type='password' name='password_confirmation' id='password-confirm' class="form-control" placeholder="Повторите пароль" required autofocus>
                                </div>
                                
                                <div class="field-set">
                                    <input type='submit' id='send_message' value='Регистрация' class="btn btn-main btn-fullwidth color-2">
                                </div>
                                
                                <div class="clearfix"></div>
                                
                                <div class="spacer-single"></div>

                            <!-- social icons -->
                            <ul class="list s3">
                                <li><a href="{{ route('user.login') }}">Авторизация</a></li>
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

{{-- <div class="row justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header">{{ __('Register') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('user.register') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> --}}
@endsection
