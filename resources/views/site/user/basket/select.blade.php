<form action="{{ route('basket.checkout') }}" method="get" id="profiles" class="form-border">
    <div class="col-lg-8 mb-sm-20">
        <div class="form-group">
            <select name="profile_id" class="form-control">
                <option value="0">Выберите профиль</option>
                @foreach($profiles as $profile)
                    <option value="{{ $profile->id }}"@if($profile->id == $current) selected @endif>
                        {{ $profile->title }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn-main">Выбрать</button>
        </div>
    </div>
</form>
