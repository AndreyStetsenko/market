@extends('admin.layout.side-menu')

{{ $title = 'Все пользователи' }}

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('breadcrumb-title')
{{ $title }}
@endsection

@section('subcontent')
    <h2 class="intro-y text-lg font-medium mt-10">{{ $title }}</h2>

    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible mt-5">
        <table class="table table-report -mt-2">
            <thead>
                <tr>
                    <th class="whitespace-nowrap">#</th>
                    <th class="whitespace-nowrap">Дата регистрации</th>
                    <th class="whitespace-nowrap">Имя, фамилия</th>
                    <th class="whitespace-nowrap">Адрес почты</th>
                    <th class="whitespace-nowrap">Кол-во заказов</th>
                    <th class="whitespace-nowrap"><i data-feather="edit" class="block mx-auto"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="intro-x">
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
                        <td>{{ $user->name }}</td>
                        <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                        <td>{{ $user->orders->count() }}</td>
                        <td>
                            <a href="{{ route('admin.user.edit', ['user' => $user->id]) }}">
                                <i data-feather="edit" class="block mx-auto"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $users->links() }}
@endsection

