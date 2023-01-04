<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersStats extends Model
{
    use HasFactory;

    protected $table = 'users_stats';

    protected $fillable = [
        'user_id',
        'table',
        'param_id',
        'type',
        'value',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function topSellers() {
        $topSellers = UsersStats::where('table', 'Product')->pluck('value');
        $result = 0;

        foreach($topSellers as $value){
            $result += $value;
        }

        return $result;
    }
}
