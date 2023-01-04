@extends('admin.layout.side-menu')

{{ $title = 'Создание нового товара' }}

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('breadcrumb-title')
{{ $title }}
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">{{ $title }}</h2>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" method="post" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
            @include('admin.product.part.form')
    </form>
@endsection
