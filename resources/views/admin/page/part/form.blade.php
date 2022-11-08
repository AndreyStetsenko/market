<div class="intro-y col-span-12 lg:col-span-6">
    <!-- BEGIN: Form Layout -->
    <div class="intro-y box p-5">

        @csrf

        <div>
            <label class="form-label">Наименование</label>
            <input type="text" name="name" class="form-control w-full" value="{{ old('name') ?? $page->name ?? '' }}" required>
        </div>

        <div class="mt-3">
            <label class="form-label">ЧПУ (на англ.)</label>
            <input type="text" name="slug" class="form-control w-full" value="{{ old('slug') ?? $page->slug ?? '' }}" required>
        </div>

        <div class="mt-3">
            @php
                $parent_id = old('parent_id') ?? $page->parent_id ?? 0;
            @endphp
            <label class="form-label">Родитель</label>
            <select name="parent_id" class="form-control w-full" title="Родитель" required>
                <option value="0">Без родителя</option>
                @foreach($parents as $parent)
                    <option value="{{ $parent->id }}" @if ($parent->id == $parent_id) selected @endif>
                        {{ $parent->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mt-3">
            <label class="form-label">Контент (html)</label>
            <textarea class="form-control w-full" name="content" placeholder="Контент (html)"
                    rows="3">{{ old('content') ?? $page->content ?? '' }}</textarea>
        </div>
        
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>

    </div>
</div>