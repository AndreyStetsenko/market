@extends('site.layout.main')

@section('content')
<div id="top"></div>
            
<!-- section begin -->
<section id="subheader">
    <div class="center-y relative text-center">
        <div class="container">
            <div class="row">
                
                <div class="col-md-12 text-center">
                    <h1>Создайте коллекцию или товар</h1>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>
<!-- section close -->


<!-- section begin -->
<section aria-label="section">
    <div class="container">
        <div class="row wow fadeIn">
            <div class="col-md-6 offset-md-3">
                <p>Выберите "Товар" если у вас уже есть коллекция и вы хотите создать товар. Выберите "Коллекция" если вы хотите создать коллекцию для своих товаров</p>
                <a href="{{ route('user.product.create') }}" class="opt-create" 
                    @if ($products_count == 0)
                    onclick="event.preventDefault();" style="opacity: 0.2" 
                    data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-title="У вас нет ни одной коллекции для создания товара. Сначала создайте коллекцию"
                    @endif>
                    <img src="{{ asset('site/images/misc/grey-coll-single.png') }}" alt="">
                    <h3>Товар</h3>
                </a>
                <a href="{{ route('user.collection.create') }}" class="opt-create">
                    <img src="{{ asset('site/images/misc/grey-coll-multiple.png') }}" alt="">
                    <h3>Коллекция</h3>
                </a>
            </div>                             
        </div>
    </div>
</section>
@endsection