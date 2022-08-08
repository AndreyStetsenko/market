@extends('site.layout.main')

@section('content')

<div id="top"></div>
            
<!-- section begin -->
<section id="subheader">
        <div class="center-y relative text-center">
            <div class="container">
                <div class="row">
                    
                    <div class="col-md-12 text-center">
                        <h1>Редактировать {{ $product->name }}</h1>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
</section>
<!-- section close -->


<!-- section begin -->
<section aria-label="section">
    <div class="container">
        <div class="row wow fadeIn">
            <div class="col-lg-7 offset-lg-1">
                <form id="product-create" class="form-border" method="post" action="{{ route('user.product.update', $product->id) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <input type="hidden" name="creator_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="slug" value="{{ old('slug') ?? $product->slug ?? '' }}">
                    <input type="hidden" name="brand_id" value="1">

                    <div class="field-set">
                        <h5>Загрузить изображение</h5>

                        <div class="d-create-file">
                            <p id="file_name">PNG, JPG, JPEG</p>
                            <input type="button" id="get_file" class="btn-main" value="Browse">
                            <input type="file" class="form-control-file" id="upload_file" 
                                    name="image" accept="image/png, image/jpeg, image/jpg">
                        </div>

                        <div class="spacer-40"></div>

                        <h5>Название</h5>
                        <input type="text" name="name" id="name" class="form-control" placeholder="e.g. 'Crypto Funk"
                                required maxlength="100" value="{{ old('name') ?? $product->name ?? '' }}" />

                        <div class="spacer-20"></div>

                        <h5>Цена</h5>
                        <input type="text" name="price" id="price" class="form-control" placeholder="25.00 $" 
                                required value="{{ old('price') ?? $product->price ?? '' }}"/>

                        <div class="spacer-20"></div>

                        <div class="form-group">
                            <!-- новинка -->
                            <div class="form-check form-check-inline">
                                @php
                                    $checked = false; // создание нового товара
                                    if (isset($product)) $checked = $product->new; // редактирование товара
                                    if (old('new')) $checked = true; // были ошибки при заполнении формы
                                @endphp
                                <input type="checkbox" name="new" class="form-check-input" id="new-product"
                                       @if($checked) checked @endif value="1">
                                <label class="form-check-label" for="new-product">Новинка</label>
                            </div>
                            <!-- лидер продаж -->
                            <div class="form-check form-check-inline">
                                @php
                                    $checked = false; // создание нового товара
                                    if (isset($product)) $checked = $product->hit; // редактирование товара
                                    if (old('hit')) $checked = true; // были ошибки при заполнении формы
                                @endphp
                                <input type="checkbox" name="hit" class="form-check-input" id="hit-product"
                                       @if($checked) checked @endif value="1">
                                <label class="form-check-label" for="hit-product">Лидер продаж</label>
                            </div>
                            <!-- распродажа -->
                            <div class="form-check form-check-inline ">
                                @php
                                    $checked = false; // создание нового товара
                                    if (isset($product)) $checked = $product->sale; // редактирование товара
                                    if (old('sale')) $checked = true; // были ошибки при заполнении формы
                                @endphp
                                <input type="checkbox" name="sale" class="form-check-input" id="sale-product"
                                       @if($checked) checked @endif value="1">
                                <label class="form-check-label" for="sale-product">Распродажа</label>
                            </div>
                        </div>

                        <div class="spacer-20"></div>

                        <h5>Категория</h5>
                        <div class="form-group">
                            @php
                                $category_id = old('category_id') ?? $product->category_id ?? 0;
                            @endphp
                            <select name="category_id" class="form-control" title="Категория" required>
                                <option value="">Выберите</option>
                                @if (count($items))
                                    @include('admin.product.part.branch', ['level' => -1, 'parent' => 0])
                                @endif
                            </select>
                        </div>

                        <div class="spacer-20"></div>

                        <h5>Коллекция</h5>
                        <div class="form-group">
                            <select name="collection_id" class="form-control" title="Коллекция" required>
                                <option value="">Выберите</option>
                                @foreach($collections as $collection)
                                    <option value="{{ $collection->id }}" @if ($collection->id == $product->collection_id) selected @endif>
                                        {{ $collection->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="spacer-20"></div>

                        <h5>Описание</h5>
                        <textarea data-autoresize name="content" id="item_desc" class="form-control" placeholder="e.g. 'This is very limited item'">{!! old('content') ?? $product->content ?? '' !!}</textarea>

                        <div class="spacer-20"></div>

                        <input type="submit" id="submit" class="btn-main" value="Обновить">
                        <div class="spacer-single"></div>
                    </div>
                </form>
            </div>

            <div class="col-lg-3 col-sm-6 col-xs-12">
                <h5>Предпросмотр</h5>
                <div class="nft__item style-2" id="product-create-preview">
                    <div class="author_list_pp">
                        <a href="{{ route('user.profile', auth()->user()->id) }}" onclick="event.preventDefault()">                                    
                            @if (auth()->user()->avatar != 'avatar.jpeg')
                                @php($url = url('storage/catalog/avatar/image/' . auth()->user()->avatar))
                                <img src="{{ $url }}" class="lazy img-fluid" alt="" style="width: 50px;height: 50px !important;object-fit: cover;">
                            @else
                                <img src="{{ asset( 'img/' . auth()->user()->avatar ) }}" class="lazy img-fluid" alt="">
                            @endif
                            <i class="fa fa-check"></i>
                        </a>
                    </div>
                    <div class="nft__item_wrap">
                        <div>
                            @if ($product->image != 'avatar.jpeg')
                                @php($url = url('storage/catalog/product/source/' . $product->image))
                                <img src="{{ $url }}" id="get_file_2" class="lazy lazy nft__item_preview" alt="">
                            @else
                                <img src="{{ asset('site/images/collections/coll-item-3.jpg') }}" id="get_file_2" class="lazy lazy nft__item_preview" alt="">
                            @endif
                        </div>
                    </div>
                    <div class="nft__item_info">
                        <a href="#">
                            <h4 class="product-preview-name">{{ $product->name }}</h4>
                        </a>
                    </div>
                    <div class="nft__item_price">
                            <span class="ms-0">{{ $product->price }}</span> USD
                        </div>
                        <div class="nft__item_action">
                            <a href="#" onclick="event.preventDefault()">Подробнее</a>
                        </div>
                    </div> 
                    <div class="d-flex justify-content-between">
                        <form method="post" action="{{ route('user.product.destroy', $product->id)}}">
                            @csrf
                            @method('DELETE')
                            
                            <input type="submit" id="submit" class="btn-main btn-danger" value="Удалить" onclick="if(confirm('Bы уверены, что хотите удалить товар?')) return true; else return false;">
                        </form>
                        <a href="{{ route('catalog.product', $product->slug) }}" class="btn-main" target="_blank">Просмотр</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection