<header class="transparent scroll-dark">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="de-flex sm-pt10">
                    <div class="de-flex-col">
                        <div class="de-flex-col">
                            <!-- logo begin -->
                            <div id="logo">
                                <a href="{{ route('index') }}" class="text-white">
                                    HashMarket
                                </a>
                            </div>
                            <!-- logo close -->
                        </div>
                        <div class="de-flex-col">
                            <form action="{{ route('catalog.search') }}" class="form-inline my-2 my-lg-0">
                                <input id="quick_search" class="xs-hide style-2" 
                                        name="query" placeholder="Поиск..." type="text" />
                            </form>
                        </div>
                    </div>
                    <div class="de-flex-col header-col-mid">
                        <!-- mainmenu begin -->
                        <ul id="mainmenu">
                            <li class="nav-item" id="top-basket">
                                <a class="nav-link"
                                   href="{{ route('catalog.index') }}">
                                    Каталог
                                </a>
                            </li>
                            <li class="nav-item" id="top-basket">
                                <a class="nav-link"
                                   href="{{ route('basket.index') }}">
                                    Корзина
                                    @if ($positions) ({{ $positions }}) @endif
                                </a>
                            </li>
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.login') }}">Войти</a>
                                </li>
                            @else
                                {{-- <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.product.index') }}">Мои товары</a>
                                </li> --}}
                            @endif
                        </ul>

                        @guest
                        <div class="menu_side_area">
                            <a href="{{ route('user.register') }}" class="btn-main btn-wallet"><i class="icon_wallet_alt"></i><span>Регистрация</span></a>
                            <span id="menu-btn"></span>
                        </div>
                        @else
                        <div class="menu_side_area">
                            <div class="de-login-menu">
                                @if (auth()->user()->manager)
                                <a href="{{ route('user.create.option') }}" class="btn-main btn-wallet"><i class="icon_wallet_alt"></i><span>Создать</span></a>
                                @endif

                                <span id="de-click-menu-profile" class="de-menu-profile">
                                    @if (auth()->user()->avatar != 'avatar.jpeg')
                                        @php($url = url('storage/catalog/avatar/image/' . auth()->user()->avatar))
                                        <img src="{{ $url }}" class="img-fluid" alt="" style="width: 45px;height: 45px;object-fit: cover;">
                                    @else
                                        <img src="{{ asset( 'img/' . auth()->user()->avatar ) }}" class="img-fluid" alt="">
                                    @endif
                                </span>

                                <div id="de-submenu-profile" class="de-submenu">
                                    <div class="d-name">
                                        <h4>{{ auth()->user()->name }}</h4>
                                    </div>
                                    <div class="spacer-10"></div>

                                    <div class="d-wallet">
                                        <h4>Кошелек</h4>
                                        <span class="d-wallet-address">{{ auth()->user()->balance }} {{ auth()->user()->wallet['meta']['currency'] }}</span>
                                        <button id="btn_copy" title="Copy Text" data-hash="{{ auth()->user()->wallet['uuid'] }}">Copy</button>
                                    </div>
            
                                    <div class="d-line"></div>
            
                                    <ul class="de-submenu-profile">
                                        @if ( auth()->user()->admin )
                                            <li><a href="{{ route('admin.index') }}" target="_blank"><i class="fa fa-user"></i> Админ панель</a></li>
                                        @endif
                                        @if ( auth()->user()->manager )
                                        <li><a href="{{ route('user.personal') }}"><i class="fa fa-user"></i> Мой профиль</a></li>
                                        @else
                                        <li><a href="{{ route('user.personal.orders') }}"><i class="fa fa-user"></i> Мой профиль</a></li>
                                        @endif
                                        <li><a href="{{ route('user.edit') }}"><i class="fa fa-pencil"></i> Редактировать</a></li>
                                        <li>
                                        <form action="{{ route('user.logout') }}" method="post" class="p-0 m-0" id="form-user-logout">
                                            @csrf
                                            {{-- <i class="fa fa-sign-out"></i> <input type="submit" value="Выйти" class="btn btn-link text-white text-decoration-none p0 m0"> --}}
                                            {{-- <button type="submit" class="btn btn-link text-white text-decoration-none p0 m0"><i class="fa fa-sign-out"></i> Выйти</button> --}}
                                            <a href="#" onclick="document.getElementById('form-user-logout').submit();"><i class="fa fa-sign-out"></i> Выход</a>
                                        </form>
                                        </li>
                                    </ul>
                                </div>
                                <span id="menu-btn"></span>
                            </div>
                        </div>
                        @endif
                        <!-- mainmenu close -->
                    </div>

                </div>
            </div>
        </div>
    </div>
</header>