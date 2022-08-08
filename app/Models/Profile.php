<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\RecordsActivity;

class Profile extends Model {

    use RecordsActivity;

    protected $fillable = [
        'user_id',
        'title',
        'name',
        'email',
        'phone',
        'address',
        'comment',
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
