<div class="col-md-12">
    <div class="d_profile de-flex">
        <div class="de-flex-col">
            <div class="profile_avatar">
                @if ($user->avatar != 'avatar.jpeg')
                    @php($url = url('storage/catalog/avatar/image/' . $user->avatar))
                    <img src="{{ $url }}" class="img-fluid" alt="" style="width: 150px;height: 150px !important;object-fit: cover;">
                @else
                    <img src="{{ asset( 'img/' . $user->avatar ) }}" class="img-fluid" alt="">
                @endif
                <i class="fa fa-check"></i>
                <div class="profile_name">
                    <h4>
                        {{ $user->name }}
                        <span class="profile_username">{{ $user->username != null ? '@' . $user->username : '' }}</span>
                        <span id="wallet_personal" class="profile_wallet">{{ $user->wallet->first()->wallet ?? '' }}</span>
                        <button id="btn_copy" title="Copy Text" class="ms-2" onclick="">Copy</button>
                    </h4>
                </div>
            </div>
        </div>

    </div>
</div>