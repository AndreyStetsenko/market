@extends('site.layout.main')

@section('content')

<div id="top"></div>
            
<!-- section begin -->
<section id="subheader">
        <div class="center-y relative text-center">
            <div class="container">
                <div class="row">
                    
                    <div class="col-md-12 text-center">
                        <h1>Детали транзакции</h1>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
</section>
<!-- section close -->

<!-- section begin -->
<section id="section-main" aria-label="section">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mx-auto">
                <div class="box-url">

                    <ul class="transaction-details-list">
                        <li>
                            {{-- <strong>Status</strong> --}}
                            <span class="text-{{ $statusColor }}">{{ $statusMessage }}</span>
                        </li>
                        <li>
                            {{-- <strong>{{ $item->wallet()->name }}</strong> --}}
                            <span>{{ $item->amount / 100 }} {{ $item->wallet()->name }}</span>
                        </li>
                        <li>
                            {{-- <strong>Date</strong> --}}
                            <span>{{ date( ('M d, Y H:m'), strtotime($item->created_at)) }}</span>
                        </li>
                    </ul>
            
                    @if ($item->confirmed == 0)
                        @if ($item->checkout_url == '')
                        <form action="{{ route('user.refill.cp') }}" method="post">
                            @csrf
            
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <input type="hidden" name="amount" value="{{ $item->amount / 100 }}">
                            <input type="hidden" name="success_url" value="{{ Request::fullUrl() }}">
                            <button class="btn btn-success mt-3 w-100">Pay</button>
                        </form>
                        @else
                        <a href="{{ route('dashboard.transaction.pay', $item->uuid) }}" class="btn btn-success mt-3">Pay</a>
                        @endif
                    @elseif ($item->confirmed == -1)
                    <a href="{{ route('dashboard.wallet', $item->wallet()->slug) }}" class="btn btn-success mt-3">To My Wallet</a>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</section>

@endsection