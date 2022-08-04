@extends('admin.layout.side-menu')

{{ $title = 'Редактирование заказа' }}

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
                    <h2 class="font-medium text-base mr-auto">Редактирование заказа</h2>
                </div>
                <div id="input" class="p-5">
                    <form class="preview" method="post" action="{{ route('admin.order.update', ['order' => $order->id]) }}">
                        @csrf
                        @method('PUT')

                        <div>
                            @php($status = old('status') ?? $order->status ?? 0)
                            <label for="name" class="form-label">Статус заказа</label>
                            <select name="status" class="form-control" title="Статус заказа">
                            @foreach ($statuses as $key => $value)
                                <option value="{{ $key }}" @if ($key == $status) selected @endif>
                                    {{ $value }}
                                </option>
                            @endforeach
                            </select>
                        </div>

                        <div class="mt-3">
                            <label for="name" class="form-label">Имя, Фамилия</label>
                            <input id="name" name="name" type="text" class="form-control" 
                                    required maxlength="255" placeholder="Имя, Фамилия" value="{{ old('name') ?? $order->name ?? '' }}">
                        </div>

                        <div class="mt-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" name="email" type="email" class="form-control" 
                                    required maxlength="255" placeholder="Email" value="{{ old('email') ?? $order->email ?? '' }}">
                        </div>

                        <div class="mt-3">
                            <label for="phone" class="form-label">Номер телефона</label>
                            <input id="phone" name="phone" type="text" class="form-control" 
                                    required maxlength="255" placeholder="Номер телефона" value="{{ old('phone') ?? $order->phone ?? '' }}">
                        </div>

                        <div class="mt-3">
                            <label for="address" class="form-label">Адрес доставки</label>
                            <input id="address" name="address" type="text" class="form-control" 
                                    required maxlength="255" placeholder="Адрес доставки" value="{{ old('address') ?? $order->address ?? '' }}">
                        </div>

                        <div class="mt-3">
                            <label for="name" class="form-label">Комментарий</label>
                            <textarea name="comment" id="comment" class="form-control" 
                                        required maxlength="255" cols="30" rows="10">{!! old('comment') ?? $order->comment ?? '' !!}</textarea>
                        </div>

                        <button class="btn btn-primary mt-5">Сохранить</button>

                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

