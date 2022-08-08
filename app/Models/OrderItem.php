<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\RecordsActivity;

class OrderItem extends Model
{
    use RecordsActivity;

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'name',
        'price',
        'quantity',
        'cost',
    ];

    /**
     * Связь «элемент принадлежит» таблицы `order_item` с таблицей `products`
     */
    public function product() {
        return $this->belongsTo(Product::class);
    }
}
