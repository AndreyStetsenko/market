@extends('layout.site', ['title' => 'Редактирование товара'])

@section('content')
    <h1>Редактирование товара</h1>
    <form method="post" enctype="multipart/form-data"
          action="{{ route('user.product.update', ['product' => $product->id]) }}">
        @method('PUT')
        @include('user.product.part.form')
    </form>
@endsection
