@extends('admin.layout.side-menu')

{{ $title = 'Активность' }}

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('breadcrumb-title')
{{ $title }}
@endsection

@section('subcontent')
    @foreach ($activities as $item)
        {{ $item->type }}
    @endforeach
@endsection