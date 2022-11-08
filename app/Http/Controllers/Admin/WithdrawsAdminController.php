<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class WithdrawsAdminController extends Controller
{
    public function withdraws()
    {
        $withdraws = Transaction::where('confirmed', '0')->where('is_withdraw', '1')->orderBy('id', 'desc')->paginate(10);

        return view('admin.withdraws.index', compact('withdraws'));
    }

    public function withdrawSuccess(Request $request)
    {
        $transaction = Transaction::find($request->id);

        $transaction->confirmed = 1;
        $transaction->update();

        return redirect()->route('admin.withdraws');
    }
}
