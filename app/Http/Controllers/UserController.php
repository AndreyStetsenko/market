<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Collection;
use App\Helpers\ImageSaver;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    
    private $imageSaver;

    public function __construct(ImageSaver $imageSaver) {
        $this->imageSaver = $imageSaver;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        return view('user.index');
    }

    public function profile(User $user) {
        $products = Product::where('creator_id', $user->id)->get();
        $collections = Collection::where('user_id', $user->id)->get();
        
        return view('site.user.index', compact('user', 'products', 'collections'));
    }

    public function edit() {
        $user = auth()->user();        
        return view('site.user.profile.edit', compact('user'));
    }

    public function update(Request $request) {
        $user = User::find(auth()->user()->id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->username = $request->input('username');
        if ($request->image) $user->avatar = $this->imageSaver->upload($request, null, 'avatar');
        $user->password = Hash::make($request->input('password'));
        $user->update();
        
        return redirect()
            ->route('user.edit')
            ->with('success', 'Учетная запись обновлена');
    }

    public function personal() {
        $user = auth()->user();
        $products = Product::where('creator_id', $user->id)->get();
        $collections = Collection::where('user_id', $user->id)->get();
        
        return view('site.user.personal', compact('user', 'products', 'collections'));
    }

    /**
     * Выбор создания коллекции или товара
     */
    public function option() {
        return view('site.user.create-option');
    }
}

