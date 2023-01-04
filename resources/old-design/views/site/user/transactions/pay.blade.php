@extends('site.layout.main')

@section('content')

@php
    auth()->user()->wallet->refresh
@endphp

<div id="top"></div>
            
<!-- section begin -->
<section id="subheader">
        <div class="center-y relative text-center">
            <div class="container">
                <div class="row">
                    
                    <div class="col-md-12 text-center">
                        <h1>Оплата</h1>
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

                    <div class="card" id="cardPay" style="display: none;">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <img id="qrCode" src="{{ $item->qrcode_url }}" alt="{{ $item->address }}">
            
                            <div class="form-group basic mt-3">
                                <div class="input-wrapper" id="addressTrans">
                                    <label class="label" for="address">Transaction Address</label>
                                    <div class="exchange-group small" bis_skin_checked="1">
                                        <div class="input-col" bis_skin_checked="1">
                                            <input type="text" class="form-control form-control-lg pe-0" id="address" value="{{ $item->address }}">
                                        </div>
                                    </div>
                                </div>
            
                                <div id="progressBar">
                                    <div class="bar"></div>
                                </div>
                                
                                <div id="time"></div>
            
                                <a href="{{ route('user.refill.details', $item->uuid) }}" class="btn btn-primary btn-lg btn-block mt-3" id="btnDetails" style="display: none">Payment Details</a>
                            </div>
                        </div>
                    </div>
            
                    <div class="card" id="cardStatus" style="display: none;">
                        <div class="card-body d-flex flex-column justify-content-center">
                            
                            <div class="listed-detail mt-3">
                                <div class="icon-wrapper">
                                    <div class="iconbox icon-box bg-success">
                                        <ion-icon name="checkmark-outline"></ion-icon>
                                    </div>
                                </div>
                                <h3 class="text-center mt-2 box-title" style="text-transform: capitalize"></h3>
            
                                <a href="{{ route('user.refill.details', $item->uuid) }}" class="btn btn-success w-100 mt-4">Payment Details</a>
                            </div>
            
                        </div>
                    </div>

                    {{-- <form action="{{ route('user.refill.cancel') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <input type="hidden" name="txn_id" value="{{ $item->txn_id }}">

                        <button class="btn-main d-block w-100 mt-5">Отмена платежа</button>
                    </form> --}}
                    <a href="{{ route('user.wallet') }}" class="btn-main d-block w-100 mt-2">Обратно в кошелек</a>
                    
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    <style>
        #progressBar {
            width: 90%;
            margin: 25px auto 10px;
            height: 12px;
            background-color: #eee;
            border-radius: 8px;
            overflow: hidden;
        }

        #progressBar div {
            height: 100%;
            text-align: right;
            padding: 0 10px;
            line-height: 22px; /* same as #progressBar height if we want text middle aligned */
            width: 0;
            background-color: #f7c0ba;
            box-sizing: border-box;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
        }

        #time {
            display: block;
            text-align: center
        }

        #qrCode {
            border-radius: 8px;
            overflow: hidden;
        }

        .card {
            background-color: transparent;
            border: none;
        }
    </style>

    <script>
        function progress(timeleft, timetotal, $element) {
            var progressBarWidth = timeleft * $element.width() / timetotal;
            $element.find('div').animate({ width: progressBarWidth }, 500);
            $('#time').html(Math.floor(timeleft/60) + ":" + timeleft%60);
            if(timeleft > 0) {
                setTimeout(function() {
                    progress(timeleft - 1, timetotal, $element);
                }, 1000);
            } else {
                $('#time').html('The time to make a payment has expired');
                $('#addressTrans').css('display', 'none');
                $('#progressBar').css('display', 'none');
                $('#qrCode').css('display', 'none');
                $('#btnDetails').css('display', 'flex');
            }
        };

        function check() {
            $.ajax({
                url: '{{ route("user.refill.check") }}',
                data: {
                    txn_id: '{{ $item->txn_id }}',
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                method: 'POST',
                success: (res) => {
                    var sTime = new Date(res.time_created*1000)
                    var eTime = new Date(res.time_expires*1000)
                    var hours = sTime.getHours(); // Получили часы
                    var minutes = sTime.getMinutes(); // Получили минуты

                    var workDate = new Date(); // Генерируем дату 8:00 следующего дня
					var diff = workDate - sTime; // Разница дат в миллисекундах
					var sec = ((diff/1000)); // Разница в минутах

                    var timeout = '{{ $item->timeout }}' - Math.round(sec);

                    if (res.status == 0) {
                        $('#cardPay').css('display', 'block');
                        $('#cardStatus').css('display', 'none');
                        updateStatus(res.status);
                    } else if (res.status == 1) {
                        $('#cardPay').css('display', 'none');
                        $('#cardStatus').css('display', 'block');
                        $('#cardStatus .iconbox').removeClass('bg-danger');
                        $('#cardStatus .iconbox').addClass('bg-success');
                        $('#cardStatus ion-icon').attr('name', 'checkmark-outline');
                        $('#cardStatus .box-title').html(res.status_text);
                        updateStatus(res.status);
                    } else if (res.status == -1) {
                        $('#cardPay').css('display', 'none');
                        $('#cardStatus').css('display', 'block');
                        $('#cardStatus .iconbox').removeClass('bg-success');
                        $('#cardStatus .iconbox').addClass('bg-danger');
                        $('#cardStatus ion-icon').attr('name', 'close');
                        $('#cardStatus .box-title').html(res.status_text);
                        updateStatus(res.status);
                    }
                    
                    console.log(res);

                    progress(timeout, '{{ $item->timeout }}', $('#progressBar'));
                },
                error: (err) => {
                    console.log(err);
                }
            });
        }

        check();

        // setInterval(() => {
        //     check();
        // }, 15000);

        function updateStatus(status) {
            $.ajax({
                url: '{{ route("user.refill.update") }}',
                data: {
                    id: '{{ $item->id }}',
                    status: status
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                method: 'POST',
                success: (res) => {
                    console.log(res);
                },
                error: (err) => {
                    console.log(err);
                }
            });
        }

        document.getElementById("address").onclick = function() {
            this.select();
            document.execCommand('copy');
            alert('Address has been copied');
        }
    </script>
@endpush