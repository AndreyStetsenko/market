<?php

namespace App\Http\Controllers;

use App\Helpers\ProductFilter;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller {
    public function index() {
        $products = Product::paginate(20);
        $roots = Category::where('parent_id', 0)->get();
        $brands = Brand::popular();
        return view('site.catalog.index', compact('roots', 'brands', 'products'));
    }

    public function category(Category $category, ProductFilter $filters) {
        $products = Product::categoryProducts($category->id)
            ->filterProducts($filters)
            ->paginate(20)
            ->withQueryString();
        return view('site.catalog.category', compact('category', 'products'));
    }

    public function brand(Brand $brand, ProductFilter $filters) {
        $products = $brand
            ->products() // возвращает построитель запроса
            ->filterProducts($filters)
            ->paginate(20)
            ->withQueryString();
        return view('catalog.brand', compact('brand', 'products'));
    }

    public function product(Product $product) {
        $products = Product::where([
            ['category_id', $product->category_id],
            ['id', '!=', $product->id]
            ])->paginate(6);

        return view('site.catalog.product', compact('product', 'products'));
    }

    public function search(Request $request) {
        $search = $request->input('query');
        $query = Product::search($search);
        $products = $query->paginate(6)->withQueryString();
        return view('site.catalog.search', compact('products', 'search'));
    }
}
