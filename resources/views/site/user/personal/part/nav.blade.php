<div class="col-12">
    <ul class="de_nav">
        <li class="{{ request()->routeIs('user.personal') ? 'active' : '' }}"><a href="{{ route('user.personal') }}"><span>Мои коллекции</span></a></li>
        <li class="{{ request()->routeIs('user.edit') ? 'active' : '' }}"><a href="{{ route('user.edit') }}"><span>Редактировать профиль</span></a></li>
        <li>
            <form action="{{ route('user.logout') }}" method="post" class="p-0 m-0" id="form-user-logout-personal">
                @csrf
                <a href="#" onclick="document.getElementById('form-user-logout-personal').submit();"><span class="text-danger">Выход</span></a>
            </form>
        </li>
    </ul>
</div>