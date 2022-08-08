<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\RecordsActivity;

class Wallets extends Model
{
    use HasFactory,
        RecordsActivity;

    protected $fillable = [
        'user_id',
        'wallet',
        'currency',
        'balance',
    ];

    /**
     * Связь «профиль принадлежит» таблицы `profiles` с таблицей `users`
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}
