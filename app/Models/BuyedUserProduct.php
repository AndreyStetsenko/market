<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyedUserProduct extends Model
{
    use HasFactory;

    protected $table = 'buyed_user_product';

    protected $fillable = [
        'buyer_id',
        'creator_id',
        'product_id',
        'count',
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function creator() {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }

    public function buyer() {
        return $this->belongsTo(User::class, 'buyer_id', 'id');
    }
}
