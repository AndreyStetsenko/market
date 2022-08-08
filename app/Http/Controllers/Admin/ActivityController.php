<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;

class ActivityController extends Controller
{
    public function index() {
        $activities = Activity::get();
        return view('admin.activity.index', compact('activities'));
    }
}
