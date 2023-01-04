<div class="col-12">
    <ul class="de_nav">
        @if (auth()->user()->manager)<li class="{{ request()->routeIs('user.personal') ? 'active' : '' }}"><a href="{{ route('user.personal') }}"><span>{{ _('Мои товары') }}</span></a></li>@endif
        @if (auth()->user()->manager)<li class="{{ request()->routeIs('user.personal.collections') ? 'active' : '' }}"><a href="{{ route('user.personal.collections') }}"><span>{{ _('Мои коллекции') }}</span></a></li>@endif
        <li class="{{ request()->routeIs('user.personal.buy-products') ? 'active' : '' }}"><a href="{{ route('user.personal.buy-products') }}"><span>{{ _('Купленные товары') }}</span></a></li>
        <li class="{{ request()->routeIs('user.personal.sell-products') ? 'active' : '' }}"><a href="{{ route('user.personal.sell-products') }}"><span>{{ _('Товары на продажу') }}</span></a></li>
        <li class="{{ request()->routeIs('user.personal.orders') ? 'active' : '' }}"><a href="{{ route('user.personal.orders') }}"><span>{{ _('Мои ордеры') }}</span></a></li>
        <li class="{{ request()->routeIs('user.personal.referals') ? 'active' : '' }}"><a href="{{ route('user.personal.referals') }}"><span>{{ _('Мои рефералы') }}</span></a></li>
        <li class="{{ request()->routeIs('user.wallet') ? 'active' : '' }}"><a href="{{ route('user.wallet') }}"><span>{{ _('Кошелек') }}</span></a></li>
        <li class="{{ request()->routeIs('user.edit') ? 'active' : '' }}"><a href="{{ route('user.edit') }}"><span>{{ _('Редактировать профиль') }}</span></a></li>
        <li>
            <form action="{{ route('user.logout') }}" method="post" class="p-0 m-0" id="form-user-logout-personal">
                @csrf
                <a href="#" onclick="document.getElementById('form-user-logout-personal').submit();"><span class="text-danger">{{ _('Выход') }}</span></a>
            </form>
        </li>
        @if (auth()->user()->manager)
            @if ( request()->routeIs('user.personal') )
            <li class="float-end active"><a href="{{ route('user.product.create') }}"><span>{{ _('Создать товар') }}</span></a></li>
            @elseif ( request()->routeIs('user.personal.collections') )
            <li class="float-end active"><a href="{{ route('user.collection.create') }}"><span>{{ _('Создать коллекцию') }}</span></a></li>
            @elseif ( request()->routeIs('user.personal.collection') )
            <li class="float-end active"><a href="{{ route('user.product.create') }}"><span>{{ _('Создать товар') }}</span></a></li>
            @endif
        @endif
    </ul>
</div>