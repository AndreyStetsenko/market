@csrf
<div class="mt-3">
    <label for="name" class="form-label">Наименование</label>
    <input id="name" name="name" type="text" class="form-control" 
            required maxlength="255" placeholder="Наименование" value="{{ old('name') ?? $category->name ?? '' }}">
</div>

<div class="mt-3">
    <label for="slug" class="form-label">ЧПУ (на англ.)</label>
    <input id="slug" name="slug" type="text" class="form-control" 
            required maxlength="255" placeholder="ЧПУ (на англ.)" value="{{ old('slug') ?? $category->slug ?? '' }}">
</div>

<div class="mt-3">
    @php
        $parent_id = old('parent_id') ?? $category->parent_id ?? 0;
    @endphp
    <label for="parent_id" class="form-label">Родитель</label>
    <select name="parent_id" id="parent_id" class="form-control" title="Родитель">
        <option value="0">Без родителя</option>
        @if (count($items))
            @include('admin.category.part.branch', ['level' => -1, 'parent' => 0])
        @endif
    </select>
</div>

<div class="mt-3">
    <label for="content" class="form-label">Краткое описание</label>
    <textarea id="content" class="form-control" name="content" placeholder="Краткое описание" maxlength="200"
              rows="3">{{ old('content') ?? $category->content ?? '' }}</textarea>
</div>

<div class="mt-3">
    <label for="image" class="form-label">Изображение категории</label>
    <input id="image" type="file" class="form-control" name="image" accept="image/png, image/jpeg">
</div>
@isset($category->image)
    <div class="form-group form-check mt-3">
        <input type="checkbox" class="form-check-input" name="remove" id="remove">
        <label class="form-check-label" for="remove">
            Удалить загруженное изображение
        </label>
    </div>
@endisset
<div class="mt-3">
    <button type="submit" class="btn btn-primary">Сохранить</button>
</div>
