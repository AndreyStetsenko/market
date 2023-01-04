<div class="intro-y col-span-12 lg:col-span-6">
    <!-- BEGIN: Form Layout -->
    <div class="intro-y box p-5">
        @csrf

        <div>
            <label class="form-label">Наименование</label>
            <input type="text" name="name" class="form-control w-full" value="{{ old('name') ?? $page->name ?? '' }}" required>
        </div>

        <div class="mt-3">
            <label class="form-label">URL</label>
            <input type="text" name="uri" class="form-control w-full" value="{{ old('uri') ?? $page->uri ?? '' }}" required>
        </div>

        <button class="btn btn-main mt-3">Создать</button>

    </div>
</div>