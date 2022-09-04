@extends('site.layout.main')

@section('content')

<div id="top"></div>
            
<!-- section begin -->
<section id="subheader">
        <div class="center-y relative text-center">
            <div class="container">
                <div class="row">
                    
                    <div class="col-md-12 text-center">
                        <h1>Создать товар</h1>
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
                <form id="product-create" class="form-border form-product-create" method="post" action="{{ route('user.product.store') }}" 
                        enctype="multipart/form-data"
                        data-formtype="product" 
                        data-formaction="create">
                    @csrf

                    <input type="hidden" name="creator_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="slug" value="{{ $slug }}">
                    <input type="hidden" name="brand_id" value="1">
                    <input type="hidden" id="check_img" value="1">

                    <div class="field-set">
                        <h5>Загрузить изображения *</h5>

                        <div class="spacer-40"></div>

                        <div class="form-group add-images">
                            <ul class="add-images-wrap"></ul>
                            <label class="form-file-add form-file-btn" data-imgs="0" id="formFileAdd">
                                <span class="cont"><i class="fa fa-plus"></i></span>
                            </label>
                        </div>

                        <div class="form-group mt-3">
                            <input type="text" name="images" id="imgOnCheck" style="opacity: 0; display: block; height: 0; margin: 0; padding: 0">
                            <div class="input-error"></div>
                        </div>

                        <div class="spacer-40"></div>

                        <div class="form-group">
                            <h5>Название *</h5>
                            <input type="text" name="name" id="name" class="form-control" placeholder="e.g. 'Crypto Funk"
                                required maxlength="100" value="{{ old('name') ?? $product->name ?? '' }}" maxlength="25" />
                            <div class="input-error"></div>
                        </div>

                        <div class="spacer-20"></div>

                        <div class="form-group price">
                            <h5>Цена *</h5>
                            <input type="text" name="price" id="price" class="form-control" placeholder="25.00 $" 
                                    required value="{{ old('price') ?? $product->price ?? '' }}" />
                            <div class="el-price">$</div>
                            <div class="input-error"></div>
                        </div>

                        <div class="spacer-20"></div>

                        <div class="form-group">
                            <h5>Категория *</h5>
                            @php
                                $category_id = old('category_id') ?? $product->category_id ?? 0;
                            @endphp
                            <select name="category_id" id="category_id" class="form-control" title="Категория" required>
                                <option value="">Выберите</option>
                                @if (count($items))
                                    @include('admin.product.part.branch', ['level' => -1, 'parent' => 0])
                                @endif
                            </select>
                            <div class="input-error"></div>
                        </div>

                        <div class="spacer-20"></div>

                        <div class="form-group">
                            <h5>Коллекция</h5>
                            <select name="collection_id" id="collection_id" class="form-control" title="Коллекция">
                                <option value="">Выберите</option>
                                @foreach($collections as $collection)
                                    <option value="{{ $collection->id }}">
                                        {{ $collection->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="input-error"></div>
                        </div>

                        <div class="spacer-20"></div>

                        {{-- <h5>Бренд</h5>
                        <div class="form-group">
                            @php
                                $brand_id = old('brand_id') ?? $product->brand_id ?? 0;
                            @endphp
                            <select name="brand_id" class="form-control" title="Бренд" required>
                                <option value="0">Выберите</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" @if ($brand->id == $brand_id) selected @endif>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="spacer-20"></div> --}}

                        <div class="form-group">
                            <h5>Описание</h5>
                            <textarea data-autoresize name="content" id="item_desc" class="form-control" placeholder="e.g. 'This is very limited item'">{{ old('content') ?? $product->content ?? '' }}</textarea>
                            <div class="input-error"></div>
                        </div>

                        <div class="spacer-20"></div>

                        {{-- <input type="submit" id="submit" class="btn-main" value="Создать"> --}}
                        <button type="submit" id="submit" class="btn-main">Создать</button>
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
                            <img src="{{ asset('site/images/collections/coll-item-3.jpg') }}" id="get_file_2" class="lazy nft__item_preview" alt="">
                        </div>
                    </div>
                    <div class="nft__item_info">
                        <a href="#">
                            <h4 class="product-preview-name">Pinky Ocean</h4>
                        </a>
                    </div>
                    <div class="nft__item_price">
                            <span class="ms-0">20</span> USD
                        </div>
                        <div class="nft__item_action">
                            <a href="#" onclick="event.preventDefault()">Подробнее</a>
                        </div>
                    </div> 
                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@push('scripts')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
<script>
    $(document).ready(function() {
      $(".btn-success").click(function(){ 
          var html = $(".clone").html();
          $(".increment").after(html);
      });
      $("body").on("click",".btn-danger",function(){ 
          $(this).parents(".control-group").remove();
      });
    });

    // $('.add-images-wrap').sortable({
    //     axis: "x",
    //     cursor: 'move',
    //     scroll: 'false',
    //     opacity: 0.9
    // }).disableSelection();
</script>
@endpush