<div class="intro-y col-span-12 lg:col-span-6">
    <!-- BEGIN: Form Layout -->
    <div class="intro-y box p-5">

        @csrf

        <div>
            <label class="form-label">Наименование</label>
            <input type="text" name="name" class="form-control w-full" value="{{ old('name') ?? $brand->name ?? '' }}" required>
        </div>

        <div class="mt-3">
            <label class="form-label">ЧПУ (на англ.)</label>
            <input type="text" name="slug" class="form-control w-full" value="{{ old('slug') ?? $brand->slug ?? '' }}" required>
        </div>

        <div class="mt-3">
            <label class="form-label">Краткое описание</label>
            <textarea class="form-control w-full" name="content" placeholder="Краткое описание" maxlength="200"
                    rows="3">{{ old('content') ?? $brand->content ?? '' }}</textarea>
        </div>

        <div class="mt-3">
            <label class="form-label">Изображение бренда</label>
            <input type="file" class="form-control" name="image" accept="image/png, image/jpeg">
        </div>

        @isset($brand->image)
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

    </div>
</div>
