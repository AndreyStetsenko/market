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
        <form class="" method="post" action="{{ route('admin.page.update', ['page' => $page->id]) }}">
            @method('PUT')
            @include('admin.page.part.form')
        </form>
    
        <div class="">
            <div class="intro-y col-span-12 lg:col-span-6">
                <!-- BEGIN: Form Layout -->
                <div class="intro-y box p-5">
            
                    <form method="post" action="{{ route('admin.page.custom.add') }}" class="flex mb-4">
                        @csrf

                        <input type="hidden" name="page_id" value="{{ $page->id }}">
                        <input type="hidden" name="field_type" value="admin_tab">
            
                        <button type="submit" class="btn btn-primary mr-2" id="addCustom">Add</button>
                        <input type="text" name="name" class="form-control" placeholder="Name Tab Custom Fields">
                    </form>
            
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            @foreach ($meta as $index => $item)
                                <button class="nav-link @if($index == 0) active @endif" id="{{ $item->name }}" data-bs-toggle="tab" data-bs-target="#{{ $item->name }}-cont" type="button" role="tab" aria-controls="nav-home" aria-selected="true">{{ $item->value }}</button>
                            @endforeach
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        @foreach ($meta as $index => $item)
                            <div class="tab-pane fade @if($index == 0) active @endif" id="{{ $item->name }}-cont" role="tabpanel" aria-labelledby="{{ $item->name }}" tabindex="0">
                                <form action="{{ route('admin.page.custom-field.add') }}" method="POST">
                                    @csrf

                                    @foreach ($item->parent as $inp)
                                        <div class="flex mt-3" id="meta-{{ $inp->id }}">
                                            <input type="text" class="form-control" placeholder="Имя" value="{{ $inp->name }}" disabled>
                                            <input type="hidden" name="name[]" value="{{ $inp->name }}">
                                            @switch($inp->field_type)
                                                @case('string')
                                                    <input type="text" name="val[]" class="form-control ml-2" placeholder="Значение" value="{{ $inp->value }}">
                                                    @break
                                                @case('longtext')
                                                    <textarea name="val[]" class="form-control ml-2" placeholder="Значение">{{ $inp->value }}</textarea>
                                                    @break
                                                @case('img')
                                                    <input type="file" name="val[]" class="form-control ml-2" placeholder="Значение">
                                                    @break
                                                @default
                                                    <input type="text" name="val[]" class="form-control ml-2" placeholder="Значение" value="{{ $inp->value }}">
                                            @endswitch
                                            <button class="btn btn-danger ml-2 remove-field" type="button" data-delete="{{ $inp->id }}">-</button>
                                            <input type="hidden" name="field_type[]" value="{{ $inp->field_type }}">
                                            <input type="hidden" name="id[]" value="{{ $inp->id }}">
                                        </div>
                                    @endforeach

                                    <div id="input0"></div>

                                    <div class="btn-group mt-3" role="group">
                                        <div class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            +
                                        </div>
                                        
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item create-field" role="button" data-field="string" href="#">Строка</a></li>
                                            <li><a class="dropdown-item create-field" role="button" data-field="longtext" href="#">Текст</a></li>
                                            {{-- <li><a class="dropdown-item create-field" role="button" data-field="img" href="#">Картинка</a></li> --}}
                                            <li><a class="dropdown-item create-field" role="button" data-field="products" href="#">Товары</a></li>
                                        </ul>
                                    </div>

                                    <hr class="mt-3">

                                    <div class="flex mt-3"> 
                                        <button class="btn btn-success" >Save</button>
                                    </div>
                
                                    <input type="hidden" name="parent_id" value="{{ $item->id }}">
                                    <input type="hidden" name="page_id" value="{{ $page->id }}">
                                </form>
                            </div>
                        @endforeach
                    </div>
            
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    

    <script>
        $('.create-field').on('click', () => {
            setTimeout(() => {
                $(document).ready(function() {
                    $('.js-example-basic-multiple').select2({
                        tags: true,
    tokenSeparators: [',', ' ']
                    });
                });
            }, 1);
        });
    </script>
@endpush
