@extends('admin.layout.side-menu')

{{-- Временный редирект на страницу товаров --}}
{{ header('Location: ' . route('admin.product.index')) }}

@section('subhead')
    <title>Home</title>
@endsection

@section('subcontent')
    
@endsection
