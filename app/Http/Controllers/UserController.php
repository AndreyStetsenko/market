<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Collection;
use App\Models\Wallets;
use App\Helpers\ImageSaver;
use App\Models\Order;
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
        // $wallet = Wallets::where('user_id', auth()->user()->id)->get();
        // if (count($wallet) < 1) {
        //     $wallet = new Wallets();
        //     $wallet->user_id = auth()->user()->id;
        //     $wallet->currency = 'usdt';
        //     $wallet->balance = '0';
        //     $wallet->wallet = $request->wallet;
        //     $wallet->save();
        // } else {
        //     $wallet = Wallets::where([['user_id', auth()->user()->id], ['currency', 'usdt']])->first();
        //     $wallet->wallet = $request->wallet;
        //     $wallet->update();
        // }
        $user->phone = $request->input('phone');
        $user->telegram = $request->input('telegram');
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->username = $request->input('username');
        if ($request->image) $user->avatar = $this->imageSaver->upload($request, null, 'avatar');
        if ($request->input('password')) $user->password = Hash::make($request->input('password'));
        $user->update();
        
        return redirect()
            ->route('user.edit')
            ->with('success', 'Учетная запись обновлена');
    }

    public function personal() {
        $user = auth()->user();
        $products = Product::where('creator_id', $user->id)->get();
        
        return view('site.user.personal.index', compact('user', 'products'));
    }

    public function collections() {
        $user = auth()->user();
        $collections = Collection::where('user_id', $user->id)->get();
        
        return view('site.user.personal.collections', compact('user', 'collections'));
    }

    public function collectionProducts(Collection $collection) {
        $user = auth()->user();
        $products = Product::where('collection_id', $collection->id)->get();
        
        return view('site.user.personal.collection-products', compact('user', 'products', 'collection'));
    }

    /**
     * Выбор создания коллекции или товара
     */
    public function option() {
        $collections = Collection::where('user_id', auth()->user()->id)->get();
        $collection_count = count($collections);
        return view('site.user.create-option', compact('collection_count'));
    }

    public function orders() {
        $user = auth()->user();
        $orders = Order::whereUserId($user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $statuses = Order::STATUSES;

        return view('site.user.personal.orders', compact('orders', 'statuses', 'user'));
    }
}

