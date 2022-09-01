@extends('site.layout.main')

@section('content')

<div id="top"></div>

<section aria-label="section">
    <div class="container">
        <div class="row">
            @include('site.user.personal.part.head')

            <div class="col-md-12">
                <div class="de_tab tab_simple">

                    @include('site.user.personal.part.nav')
                    
                    <div class="de_tab_content">
                        
                        <div class="row">

                            <div class="col-md-8">
                                <table class="table de-table table-rank">
                                    @if ($referrals ?? '')
                                        @forelse($referrals as $referral)
                                            @forelse ($referral->relationships()->get() as $user)
                                               
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Имя</th>
                                                        <th scope="col">Баланс</th>
                                                        <th scope="col">Дата регистрации</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <a class="profile_avatar me-2" href="{{ route('user.profile', $user->user->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Пользователь: {{ $user->user->name }}" style="width: 48px; height: 48px">
                                                                    @if ($user->user->avatar != 'avatar.jpeg')
                                                                        @php($url = url('storage/catalog/avatar/source/' . $user->user->avatar))
                                                                        <img src="{{ $url }}" class="img-fluid" alt="" style="width: 45px;height: 45px !important;object-fit: cover;">
                                                                    @else
                                                                        <img src="{{ asset( 'img/' . $user->user->avatar ) }}" class="img-fluid" alt="">
                                                                    @endif
                                                                </a>
                                                                <a href="{{ route('user.profile', $user->user->id) }}">{{ $user->user->name }}</a>
                                                            </div>
                                                        </td>
                                                        <td>{{ $user->user->credits }} монет</td>
                                                        <td>{{ date('d m Y', strtotime($user->created_at)) }}</td>
                                                    </tr>
                                                </tbody>

                                            @empty
                                                Нет Рефералов
                                            @endforelse
                                        @empty
                                            
                                        @endforelse
                                    @endif
                                </table>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="box-url">
                                    @if ($referrals ?? '')
                                        @forelse($referrals as $referral)
                                            <h4>
                                                Бонус за регистрацию
                                            </h4>
                                            <span class="text-muted d-block mb-3">
                                                Пригласи пользователя и получи бонус!
                                            </span>
                                            <code>
                                                {{ $referral->link }}
                                            </code>
                                            <span class="d-block mt-3">
                                                Рефералов: {{ $referral->relationships()->count() }}
                                            </span>

                                            <span class="d-block mt-3">
                                                Баланс: {{ auth()->user()->credits == null ? 0 : auth()->user()->credits }} монет
                                            </span>
                                        @empty
                                            Реферальная программа не создана
                                        @endforelse
                                    @endif
                                </div>
                            </div>

                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>

@endsection