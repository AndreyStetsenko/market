@extends('layout.site', ['title' => 'Создание товара'])

@section('content')
    <h1>Создание нового товара</h1>
    <form method="post" action="{{ route('user.product.store') }}" enctype="multipart/form-data">
        @include('user.product.part.form')
    </form>
@endsection
