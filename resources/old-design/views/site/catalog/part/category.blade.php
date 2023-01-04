<div class="nft_coll style-2">
    <div class="nft_wrap">
        <a href="{{ route('catalog.category', ['category' => $category->slug]) }}">
            @if ($category->image)
                @php($url = url('storage/catalog/category/source/' . $category->image))
                <img src="{{ $url }}" class="lazy img-fluid" alt="">
            @else
                <img src="https://via.placeholder.com/300x150" class="lazy img-fluid" alt="">
            @endif
        </a>
    </div>
    <div class="nft_coll_info mt-4">
        <a href="{{ route('catalog.category', ['category' => $category->slug]) }}"><h4>{{ $category->name }}</h4></a>
    </div>
</div>