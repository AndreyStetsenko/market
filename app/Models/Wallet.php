<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class Wallet extends Model
{
    use HasFactory;

    public const CURR_IMG = [
        'USDT' => 'https://cdn.jsdelivr.net/gh/atomiclabs/cryptocurrency-icons@1a63530be6e374711a8554f31b17e4cb92c25fa5/svg/color/usdt.svg'
    ];

    public static function generateHashAddress()
    {
        $time = Carbon::now();
        $user_id = auth()->user()->id;
        $dt = '%07';
        $pref = 'x0';
        $result = $pref . $time . $dt . $user_id;
        $hash = Hash::make($result, [
            'memory' => 1024,
            'time' => 2,
            'threads' => 2,
        ]);

        return $hash;
    }
}
