<div class="col-12">
    <ul class="de_nav">
        @if ($user->manager)<li class="{{ request()->routeIs('user.personal') ? 'active' : '' }}"><a href="{{ route('user.personal') }}"><span>Мои товары</span></a></li>@endif
        @if ($user->manager)<li class="{{ request()->routeIs('user.personal.collections') ? 'active' : '' }}"><a href="{{ route('user.personal.collections') }}"><span>Мои коллекции</span></a></li>@endif
        <li class="{{ request()->routeIs('user.personal.orders') ? 'active' : '' }}"><a href="{{ route('user.personal.orders') }}"><span>Мои заказы</span></a></li>
        <li class="{{ request()->routeIs('user.personal.referals') ? 'active' : '' }}"><a href="{{ route('user.personal.referals') }}"><span>Мои рефералы</span></a></li>
        <li class="{{ request()->routeIs('user.edit') ? 'active' : '' }}"><a href="{{ route('user.edit') }}"><span>Редактировать профиль</span></a></li>
        <li>
            <form action="{{ route('user.logout') }}" method="post" class="p-0 m-0" id="form-user-logout-personal">
                @csrf
                <a href="#" onclick="document.getElementById('form-user-logout-personal').submit();"><span class="text-danger">Выход</span></a>
            </form>
        </li>
        @if ($user->manager)
            @if ( request()->routeIs('user.personal') )
            <li class="float-end active"><a href="{{ route('user.product.create') }}"><span>Создать товар</span></a></li>
            @elseif ( request()->routeIs('user.personal.collections') )
            <li class="float-end active"><a href="{{ route('user.collection.create') }}"><span>Создать коллекцию</span></a></li>
            @elseif ( request()->routeIs('user.personal.collection') )
            <li class="float-end active"><a href="{{ route('user.product.create') }}"><span>Создать товар</span></a></li>
            @endif
        @endif
    </ul>
</div>