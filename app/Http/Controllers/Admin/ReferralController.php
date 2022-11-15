<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReferralProgram;

class ReferralController extends Controller
{
    public function index()
    {
        $title = 'Реферальная система';

        return view('admin.referral.index', compact('title'));
    }

    public function store(Request $request)
    {
        ReferralProgram::create([
            'name' => $request->name,
            'uri' => $request->uri
        ]);

        return back()->with('success', 'Реферальная программа ' . $request->name . ' создана');
    }
}
