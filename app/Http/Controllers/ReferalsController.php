<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ReferralProgram;
use App\Models\ReferralLink;

class ReferalsController extends Controller
{
    public function userReferals() {
        $user = auth()->user();
        $referrals = User::find($user->id)->getReferrals();
        
        return view('site.user.personal.referals', compact('user', 'referrals'));
    }
}
