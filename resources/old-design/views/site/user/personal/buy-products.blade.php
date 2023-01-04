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
                            @foreach ($products as $item)
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 position-relative">
                                    <span class="p-count">{{ $item->count }}</span>
                                    @include('site.catalog.part.product', [
                                                                            'product' => $item->product, 
                                                                            'count' => $item->count, 
                                                                            'sell' => auth()->user()->is_seller,
                                                                        ])
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-5">
                            {{ $products->links('site.dop.paginate') }}
                        </div>

                        <div class="modal fade" id="modalToSell" aria-hidden="true" aria-labelledby="modalToSellLabel" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                <form action="{{ route('user.personal.sell-product.store') }}" method="post" id="product-create" class="form-border form-product-create">
                                    @csrf

                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="modalToSellLabel"></h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                            
                                        <input type="hidden" name="product_id" id="product_id">
                                        <input type="hidden" name="creator_id" id="creator_id">
                                        <input type="hidden" name="currency" id="currency" value="USD">
                                        
                                        <div class="field-set">
                                            <div class="form-group price">
                                                <h5>Цена *</h5>
                                                <input type="text" name="price" id="price" class="form-control" placeholder="25.00 $" 
                                                        required />
                                                <div class="el-price">$</div>
                                                <div class="input-error"></div>
                                            </div>
                                        
                                            <div class="form-group d-flex">
                                                <div style="width:calc(50% - 10px)">
                                                    <h5>Количество</h5>
                                                    <input type="text" name="count" id="count" class="form-control" />
                                                    <div class="input-error" id="countFirst"></div>
                                                </div>
                                                <div style="width:calc(50% - 10px);margin-left:20px">
                                                    <h5>Остаток</h5>
                                                    <input type="text" name="count_lost" id="count_lost" class="form-control" disabled/>
                                                    <div class="input-error" id="countSecond"></div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn-main" data-bs-dismiss="modal" type="submit">Выставить на продажу</button>
                                    </div>
                                </div>
                                </form>
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
    <style>
        .p-count {
            position: absolute;
            top: -8px;
            right: 1px;
            background: #27292d;
            border: 1px solid #3d3f42;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            z-index: 2;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 12px;
            box-shadow: 0 0 2px 2px rgba(0,0,0,0.2);
        }
    </style>

    <script>
        const linkProductGet = document.querySelectorAll('.get_product_mini_info');

        linkProductGet.forEach(el => {
            el.addEventListener('click', () => {
                const productId = el.getAttribute('data-product-id');

                console.log(productId);
                getProduct(productId);
            });
        });

        function getProduct(productId) {
            var route = `/pitem/${productId}`;
            const modal = $('#modalToSell');

            $.ajax({
                url: route,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                method: 'GET',
                success: (res) => {                    
                    console.log(res);

                    $(modal).find('.modal-title').text(res.name);
                    $('#price').val(res.product.price);
                    $('#count').val(res.productBuy.count);
                    $('#count_lost').val(res.productBuy.count);
                    $('#product_id').val(res.productBuy.product_id);
                    $('#creator_id').val(res.productBuy.buyer_id);
                },
                error: (err) => {
                    console.log(err);
                }
            });
        }

        var inpCount = document.getElementById('count');
        const inpCountLost = document.getElementById('count_lost');
        const countFirst = document.getElementById('countFirst');

        inpCount.addEventListener('input', () => {
            checkCount();
        });

        function checkCount() {
            if (inpCountLost.value < inpCount.value) {
                countFirst.innerHTML = 'Количество не может привышать остаток';
                countFirst.style.color = '#e7505a';
            } else {
                countFirst.innerHTML = '';
            }
        }
    </script>
@endpush