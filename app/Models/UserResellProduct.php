<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserResellProduct extends Model
{
    use HasFactory;

    protected $table = 'user_resell_product';

    protected $fillable = [
        'creator_id',
        'product_id',
        'count',
        'price',
        'currency',
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function creator() {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }
}
