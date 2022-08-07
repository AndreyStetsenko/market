@extends('site.layout.main')

@section('content')

<div id="top"></div>
            
<!-- section begin -->
<section id="subheader">
        <div class="center-y relative text-center">
            <div class="container">
                <div class="row">
                    
                    <div class="col-md-12 text-center">
                        <h1>Edit Profile</h1>
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
            <div class="col-lg-8 offset-lg-2">
                <form id="form-create-item" class="form-border" method="post" action="{{ route('user.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="de_tab tab_simple">

                    <ul class="de_nav">
                        <li class="active"><span><i class="fa fa-user"></i>Основное</span></li>
                        <li><span><i class="fa fa-exclamation-circle"></i>Безопасность</span></li>
                    </ul>
                    
                    <div class="de_tab_content">                            
                        <div class="tab-1">
                            <div class="row wow fadeIn">
                                <div class="col-lg-8 mb-sm-20">
                                        <div class="field-set">
                                            <h5>Имя</h5>
                                            <input type="text" name="name" id="name" class="form-control" 
                                                    placeholder="Имя" value="{{ $user->name }}" />

                                            <div class="spacer-20"></div>

                                            <h5>Username</h5>
                                            <input type="text" name="username" id="username" class="form-control" 
                                                    placeholder="Username" value="{{ $user->username }}" />

                                            <div class="spacer-20"></div>

                                            <h5>Email</h5>
                                            <input type="text" name="email" id="email" class="form-control" 
                                                    placeholder="Email" value="{{ $user->email }}" />

                                            <div class="spacer-20"></div>

                                            <h5>Кошелек USDT</h5>
                                            <input type="text" name="wallet" id="wallet" class="form-control" 
                                                    placeholder="Wallet" value="{{ $user->wallet[0]->wallet ?? '' }}" />

                                        </div>
                                </div>

                                <div id="sidebar" class="col-lg-4">
                                    <h5>Аватар <i class="fa fa-info-circle id-color-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Recommend 400 x 400. Max size: 50MB. Click the image to upload."></i></h5>

                                    @if ($user->avatar != 'avatar.jpeg')
                                        @php($url = url('storage/catalog/avatar/image/' . $user->avatar))
                                        <img src="{{ $url }}" id="click_profile_img" class="d-profile-img-edit img-fluid" alt="" style="width: 250px;height: 250px;object-fit: cover;">
                                    @else
                                        <img src="{{ asset('img/' . $user->avatar) }}" id="click_profile_img" class="d-profile-img-edit img-fluid" alt="">
                                    @endif
                                    
                                    <input type="file" id="upload_profile_img" name="image"> 

                                </div>                                         
                            </div>
                        </div>

                        <div class="tab-2">
                            <div class="row wow fadeIn">
                                <div class="col-lg-8 mb-sm-20">
                                        <div class="field-set">
                                            <h5>Пароль</h5>
                                            <input type="password" name="password" id="password" class="form-control" 
                                                    placeholder="Пароль" />

                                            <h5>Повторите пароль</h5>
                                            <input type="password" name="password_repeat" id="password_repeat" class="form-control" 
                                                    placeholder="Пароль" />

                                        </div>
                                </div>                                         
                            </div>
                        </div>

                    </div>
                </div>

                <div class="spacer-30"></div>
                <input type="submit" id="submit" class="btn-main" value="Обновить профиль">
                </form>
            </div>
        </div>
    </div>
</section>

@endsection