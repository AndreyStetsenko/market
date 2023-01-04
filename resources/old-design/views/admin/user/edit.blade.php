@extends('admin.layout.side-menu')

{{ $title = 'Редактирование пользователя' }}

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('breadcrumb-title')
{{ $title }}
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">

            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">{{ $title }}@if ($user->id == auth()->user()->id) (<b>Это вы</b>) @endif</h2>
                </div>
                <div id="input" class="p-5">
                    <form class="preview" method="post" action="{{ route('admin.user.update', ['user' => $user->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="mt-3">
                            <label for="name" class="form-label">Имя, Фамилия</label>
                            <input id="name" name="name" type="text" class="form-control" 
                                    required maxlength="255" placeholder="Имя, Фамилия" value="{{ old('name') ?? $user->name ?? '' }}">
                        </div>

                        <div class="mt-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" name="email" type="email" class="form-control" 
                                    required maxlength="255" placeholder="Email" value="{{ old('email') ?? $user->email ?? '' }}">
                        </div>

                        <div class="mt-3">
                            <label for="email" class="form-label">Роль</label>
                            <select name="role" class="form-control">
                                <option value="0" @if ($user->admin == false) selected @endif>Пользователь</option>
                                <option value="1" @if ($user->manager == true) selected @endif>Менеджер</option>
                                <option value="2" @if ($user->admin == true) selected @endif>Администратор</option>
                            </select>
                        </div>

                        <div class="mt-3">
                            <label for="password" class="form-label">Новый пароль</label>
                            <input id="password" name="password" type="text" class="form-control" 
                                    maxlength="255" placeholder="Новый пароль" value="{{ old('password') ?? $order->password ?? '' }}">
                        </div>

                        <div class="mt-3">
                            <label for="password_confirmation" class="form-label">Повторите пароль</label>
                            <input id="password_confirmation" name="password_confirmation" type="text" class="form-control" 
                                    maxlength="255" placeholder="Повторите пароль" value="{{ old('password_confirmation') ?? $order->password_confirmation ?? '' }}">
                        </div>

                        <div class="form-check mt-2">
                            <input id="change_password" class="form-check-input" type="checkbox" name="change_password">
                            <label class="form-check-label" for="change_password">Изменить пароль пользователя</label>
                        </div>

                        <div class="form-check flex mt-4" style="flex-direction: column;align-items:flex-start">
                            {{-- <input id="is_seller" class="form-check-input" type="checkbox" name="is_seller"> --}}
                            <label class="form-check-label ml-0" for="is_seller">Может продавать товары?</label>

                            <div class="variables mt-2">
                                <label class="mr-3">
                                    Нет
                                    <input type="radio" name="is_seller" id="is_seller" value="0" @if ($user->is_seller == false) checked @endif>
                                </label>
                                <label>
                                    Да
                                    <input type="radio" name="is_seller" id="is_seller" value="1" @if ($user->is_seller == true) checked @endif>
                                </label>
                            </div>
                        </div>

                        <button class="btn btn-primary mt-5">Сохранить</button>

                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection