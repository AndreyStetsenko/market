<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsersStats;


class UserStatsController extends Controller
{
    public function storeStat($user_id, $table, $param_id, $type, $value)
    {
        UsersStats::create([
            'user_id' => $user_id,
            'table' => $table,
            'param_id' => $param_id,
            'type' => $type,
            'value' => $value
        ]);

        return response('Ok');
    }
}
