<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wallet;

class WalletController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('site.user.personal.wallet', compact('user'));
    }
}
