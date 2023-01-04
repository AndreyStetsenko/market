<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Collection;
use App\Models\Page;
use App\Models\UsersStats;
use Illuminate\Http\Request;

class IndexController extends Controller {
    public function __invoke(Request $request) {
        $new = Product::whereNew(true)->latest()->limit(8)->get();
        $hit = Product::whereHit(true)->latest()->limit(3)->get();
        $sale = Product::whereSale(true)->latest()->limit(3)->get();
        $users = User::get();
        $collections = Collection::get();
        $count_prod = count(Product::get());
        $page = Page::where('slug', '/')->first();
        $topSellers = new UsersStats();


        return view('site.pages.index', compact('new', 'hit', 'sale', 'users', 'collections', 'count_prod', 'page', 'topSellers'));
    }
}
