@extends('admin.layout.side-menu')

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
    <div class="grid grid-cols-6 gap-6 mt-5">
        <form class="" method="post" action="{{ route('admin.referr.store') }}">
            @include('admin.referral.part.form')
        </form>
    </form>
@endsection
