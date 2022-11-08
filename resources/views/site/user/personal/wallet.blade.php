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
                                    <thead>
                                        <tr>
                                            <th scope="col">Операция</th>
                                            <th scope="col">Сумма</th>
                                            <th scope="col">Статус</th>
                                            <th scope="col">Дата</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if ($wallet ?? '')
                                        @forelse($transactions as $item)
                                        @php
                                            $statusCode = $item->confirmed;
                                            $statusText = '';
            
                                            switch ($statusCode) {
                                                case -1:
                                                    $statusText = 'Expired';
                                                    break;
            
                                                case 0:
                                                    $statusText = 'New';
                                                    break;
            
                                                case 1:
                                                    $statusText = 'Confirmed';
                                                    break;
                                                
                                                default:
                                                    $statusText = 'Warning';
                                                    break;
                                            }
                                        @endphp
                                            <tr>
                                                <td>{{ $item->type }}</td>
                                                <td>{{ $item->amount / 100 }} {{ $item->wallet->meta['currency'] }}</td>
                                                <td>{{ $statusText }}</td>
                                                <td>{{ $item->created_at }}</td>
                                            </tr>
                                        @empty
                                            Нет транзакций
                                        @endforelse
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="box-url">
                                    @if ($wallet ?? '')

                                        @if(Session::has('error'))
                                        <div class="alert alert-danger mt-3">
                                            {{ Session::get('error') }}
                                            @php
                                                Session::forget('error');
                                            @endphp
                                        </div>
                                        @endif

                                        @if(Session::has('success'))
                                        <div class="alert alert-success mt-3">
                                            {{ Session::get('success') }}
                                            @php
                                                Session::forget('success');
                                            @endphp
                                        </div>
                                        @endif

                                        <h4>
                                            Мой кошелек
                                        </h4>
                                        <span class="text-muted d-block mb-3">
                                            Это ваш USDT TRC20 кошелек
                                        </span>
                                        <code>
                                            {{ $wallet->uuid }}
                                        </code>

                                        <span class="d-block mt-3">
                                            Баланс: {{ $wallet->balance / 100 }} {{ $wallet->meta['currency'] }}
                                        </span>

                                        <div class="d-flex mt-3 justify-content-between check-transes">
                                            <label>
                                                <div class="btn-main" style="cursor: pointer" id="btn-refill">Пополнить</div>
                                                <input type="radio" name="trans" value="refill" style="display: none">
                                            </label>
                                            <label>
                                                <div class="btn-main" style="cursor: pointer" id="btn-withdraw">Вывод</div>
                                                <input type="radio" name="trans" value="withdraw" style="display: none">
                                            </label>
                                        </div>
                                        <div id="cont-refill" style="display: none">
                                            <hr>
                                            <form action="{{ route('user.refill.store') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="walletname" value="USDT TRC20">

                                                <input type="text" name="sum1" class="form-control mt-3" placeholder="Сумма пополнения" maxlength="6" required>
                                                <button class="btn-main mt-3">Пополнить</button>
                                            </form>
                                        </div>
                                        <div id="cont-withdraw" style="display: none">
                                            <hr>
                                            <form action="{{ route('user.withdraw.store') }}" method="post">
                                                @csrf

                                                <input type="text" name="sum2" class="form-control mt-3" placeholder="Сумма вывода" maxlength="6" required>
                                                <input type="text" name="bank" class="form-control mt-3" placeholder="Способ вывода (крипта, банк)" required>
                                                <input type="text" name="card" class="form-control mt-3" placeholder="Номер счета" required>
                                                <button class="btn-main mt-3">Вывести</button>
                                            </form>
                                        </div>
                                    @else
                                        Кошелек не создан
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

@push('scripts')
    <script>
        const trans = document.querySelectorAll('input[name="trans"]');
        const transes = document.querySelectorAll('.check-transes label');
        const contRefill = document.getElementById('cont-refill');
        const contWithdraw = document.getElementById('cont-withdraw');
        const btnRefill = document.getElementById('btn-refill');
        const btnWithdraw = document.getElementById('btn-withdraw');

        btnRefill.addEventListener('click', () => {
            contRefill.style.display = 'block';
            contWithdraw.style.display = 'none';

            document.querySelector('input[name="sum2"]').value = '';
            document.querySelector('input[name="bank"]').value = '';
            document.querySelector('input[name="card"]').value = '';
        });

        btnWithdraw.addEventListener('click', () => {
            contRefill.style.display = 'none';
            contWithdraw.style.display = 'block';

            document.querySelector('input[name="sum1"]').value = '';
        });
    </script>
@endpush