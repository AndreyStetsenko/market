<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    /**
     * Показывает аккаунт текущего пользователя
     *
     * @return \Illuminate\Http\Response
     */
    public function show() {
        $user = auth()->user();
        return view('user.account.show', compact('user'));
    }
}
