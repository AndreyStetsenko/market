@csrf
<input type="hidden" name="creator_id" value="{{ auth()->user()->id }}">
<div class="intro-y col-span-12 lg:col-span-6">
    <!-- BEGIN: Form Layout -->
    <div class="intro-y box p-5">
        <div>
            <label class="form-label">Наименование</label>
            <input type="text" name="name" class="form-control w-full" value="{{ old('name') ?? $product->name ?? '' }}" required>
        </div>
        <div class="mt-3">
            <label class="form-label">ЧПУ (на англ.)</label>
            <input type="text" name="slug" class="form-control w-full" value="{{ old('slug') ?? $product->slug ?? '' }}" required>
        </div>
        <div class="mt-3">
            <label for="crud-form-3" class="form-label">Цена</label>
            <div class="input-group">
                <input name="price" type="text" class="form-control" aria-describedby="price" value="{{ old('price') ?? $product->price ?? '' }}" required>
                <div id="price" class="input-group-text">$</div>
            </div>
        </div>
        <div class="mt-3">
            @php
                $checked = false; // создание нового товара
                if (isset($product)) $checked = $product->new; // редактирование товара
                if (old('new')) $checked = true; // были ошибки при заполнении формы
            @endphp
            
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" name="new" id="new-product" @if($checked) checked @endif value="1">
                <label class="form-check-label" for="new-product">Новинка</label>
            </div>

            @php
                $checked = false; // создание нового товара
                if (isset($product)) $checked = $product->hit; // редактирование товара
                if (old('hit')) $checked = true; // были ошибки при заполнении формы
            @endphp
            
            <div class="form-check mt-2">
                <input id="hit-product" class="form-check-input" type="checkbox" name="hit" @if($checked) checked @endif value="1">
                <label class="form-check-label" for="hit-product">Лидер продаж</label>
            </div>

            @php
                $checked = false; // создание нового товара
                if (isset($product)) $checked = $product->sale; // редактирование товара
                if (old('sale')) $checked = true; // были ошибки при заполнении формы
            @endphp

            <div class="form-check mt-2">
                <input id="sale-product" class="form-check-input" type="checkbox" name="sale" @if($checked) checked @endif value="1">
                <label class="form-check-label" for="sale-product">Распродажа</label>
            </div>
        </div>
        <div class="mt-3">
            @php
                $category_id = old('category_id') ?? $product->category_id ?? 0;
            @endphp
            <label class="form-label">Категория</label>
            <select name="category_id" class="tom-select w-full">
                <option value=""></option>
                @if (count($items))
                    @include('admin.product.part.branch', ['level' => -1, 'parent' => 0])
                @endif
            </select>
        </div>
        <div class="mt-3">
            @php
                $brand_id = old('brand_id') ?? $product->brand_id ?? 0;
            @endphp
            <label class="form-label">Бренд</label>
            <select name="brand_id" class="tom-select w-full" required>
                <option value=""></option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" @if ($brand->id == $brand_id) selected @endif>
                        {{ $brand->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mt-3">
            <textarea class="editor" name="content">{{ old('content') ?? $product->content ?? '' }}</textarea>
        </div>
        <div class="mt-3">
            <input type="file" class="form-control-file" name="image" accept="image/png, image/jpeg">
        </div>
        @isset($product->image)
            <div class="mt-3 form-group form-check">
                <input type="checkbox" class="form-check-input" name="remove" id="remove">
                <label class="form-check-label" for="remove">
                    Удалить загруженное изображение
                </label>
            </div>
        @endisset
        
        <div class="text-right mt-5">
            <a href="{{ route('admin.product.index') }}" class="btn btn-outline-secondary w-24 mr-1">Отмена</a>
            <button type="submit" class="btn btn-primary w-24">Сохранить</button>
        </div>
    </div>
    <!-- END: Form Layout -->
</div>

@section('script')
    <script src="{{ asset('dist/js/ckeditor-classic.js') }}"></script>
@endsection