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
                            @if (session('status'))
                                <span class="alert alert-success d-block" role="alert">
                                    <strong>{{ session('status') }}</strong>
                                </span>
                            @endif
                            <h3 class="mb10 mb-3">{{ __('Reset Password') }}</h3>
                            <form name="contactForm" id='contact_form' class="form-border" method="POST" action="{{ route('user.password.email') }}">
                                @csrf

                                <div class="field-set">
                                    <input type='text' name='email' id='email' class="form-control" placeholder="Имя пользователя / Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                </div>
                                
                                <div class="field-set">
                                    <input type='submit' id='send_message' value='Сбросить' class="btn btn-main btn-fullwidth color-2">
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
