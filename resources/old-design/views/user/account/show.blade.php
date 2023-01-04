@extends('layout.site', ['title' => 'Мой аккаунт'])

@section('content')
    <h1>Мой аккаунт</h1>

    {{-- <p><strong>Название профиля:</strong> {{ $account->title }}</p>
    <p><strong>Имя, фамилия:</strong> {{ $account->name }}</p>
    <p>
        <strong>Адрес почты:</strong>
        <a href="mailto:{{ $account->email }}">{{ $account->email }}</a>
    </p>
    <p><strong>Номер телефона:</strong> {{ $account->phone }}</p>
    <p><strong>Адрес доставки:</strong> {{ $account->address }}</p>
    @isset ($account->comment)
        <p><strong>Комментарий:</strong> {{ $account->comment }}</p>
    @endisset

    <a href="{{ route('user.profile.edit', ['profile' => $profile->id]) }}"
       class="btn btn-success">
        Редактировать профиль
    </a>
    <form method="post" class="d-inline" onsubmit="return confirm('Удалить этот профиль?')"
          action="{{ route('user.profile.destroy', ['profile' => $profile->id]) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">
            Удалить профиль
        </button>
    </form> --}}
@endsection
