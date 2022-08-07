<!-- цена (руб) -->
<select name="price" class="dropdown form-control d-inline w-25 mr-4 mb-0" title="Цена">
    <option value="0">Выберите цену</option>
    <option value="min"@if(request()->price == 'min') selected @endif>Дешевле</option>
    <option value="max"@if(request()->price == 'max') selected @endif>Дороже</option>
</select>
<div class="d-flex align-items-center h100">
    <!-- новинка -->
    <div class="form-check form-check-inline">
        <input type="checkbox" name="new" class="form-check-input" id="new-product"
            @if(request()->has('new')) checked @endif value="yes">
        <label class="form-check-label" for="new-product">Новинка</label>
    </div>
    <!-- лидер продаж -->
    <div class="form-check form-check-inline">
        <input type="checkbox" name="hit" class="form-check-input" id="hit-product"
            @if(request()->has('hit'))  checked @endif value="yes">
        <label class="form-check-label" for="hit-product">Лидер продаж</label>
    </div>
    <!-- распродажа -->
    <div class="form-check form-check-inline ">
        <input type="checkbox" name="sale" class="form-check-input" id="sale-product"
            @if(request()->has('sale'))  checked @endif value="yes">
        <label class="form-check-label" for="sale-product">Распродажа</label>
    </div>
</div>
<button class="btn-main btn-sm h100 d-flex align-items-center"><i class="fa fa-search bg-color-secondary"></i></button>
