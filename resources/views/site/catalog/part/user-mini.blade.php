<li>                                    
    <div class="author_list_pp">
        <a href="03_grey-author.html">
            @if ($user->avatar != 'avatar.jpeg')
                @php($url = url('storage/catalog/avatar/image/' . $user->avatar))
                <img src="{{ $url }}" class="img-fluid" alt="" style="width: 45px;height: 45px !important;object-fit: cover;">
            @else
                <img src="{{ asset( 'img/' . $user->avatar ) }}" class="img-fluid" alt="">
            @endif
            <i class="fa fa-check"></i>
        </a>
    </div>                                    
    <div class="author_list_info">
        <a href="03_grey-author.html">{{ $user->name }}</a>
        {{-- <span>3.2 ETH</span> --}}
    </div>
</li>