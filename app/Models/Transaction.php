<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public const STATUSES = [
        -1 => 'Expired',
        0 => 'New',
        1 => 'Confirmed',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class)->first();
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'payable_id')->first();
    }
}
