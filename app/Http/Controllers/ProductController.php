<?php

namespace App\Http\Controllers;

use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Helpers\ImageSaver;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCatalogRequest;
use App\Models\Collection;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    private $imageSaver;

    public function __construct(ImageSaver $imageSaver) {
        $this->imageSaver = $imageSaver;
    }

    /**
     * Показывает список всех товаров
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $roots = Category::where('parent_id', 0)->get();
        $products = Product::where('creator_id', auth()->user()->id)->paginate(5);
        return view('user.product.index', compact('products', 'roots'));
    }

    /**
     * Показывает товары категории
     *
     * @return \Illuminate\Http\Response
     */
    public function category(Category $category) {
        $products = $category->products()->paginate(5);
        return view('user.product.category', compact('category', 'products'));
    }

    /**
     * Показывает форму для создания товара
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $n = 64;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
    
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        // $slug = Hash::make($randomString);
        $slug = $randomString;
    
        // все коллекции пользователя
        $collections = Collection::where('user_id', auth()->user()->id)->get();
        // все категории для возможности выбора родителя
        $items = Category::all();
        // все бренды для возмозжности выбора подходящего
        $brands = Brand::all();
        return view('site.user.product.create', compact('items', 'brands', 'collections', 'slug'));
    }

    /**
     * Сохраняет новый товар в базу данных
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCatalogRequest $request) {
        $request->merge([
            'new' => $request->has('new'),
            'hit' => $request->has('hit'),
            'sale' => $request->has('sale'),
        ]);
        $data = $request->all();
        $data['image'] = $this->imageSaver->upload($request, null, 'product');
        $product = Product::create($data);
        return redirect()
            ->route('catalog.product', ['product' => $product->slug])
            ->with('success', 'Новый товар успешно создан');
    }

    /**
     * Показывает страницу товара
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product) {
        return view('user.product.show', compact('product'));
    }

    /**
     * Показывает форму для редактирования товара
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product) {
        // Коллекции текущего пользователя
        $collections = Collection::where('user_id', auth()->user()->id)->get();
        // все категории для возможности выбора родителя
        $items = Category::all();
        return view('site.user.product.edit', compact('product', 'items', 'collections'));
    }

    /**
     * Обновляет товар каталога в базе данных
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product) {
        $request->merge([
            'new' => $request->has('new'),
            'hit' => $request->has('hit'),
            'sale' => $request->has('sale'),
        ]);
        $data = $request->all();
        $data['image'] = $this->imageSaver->upload($request, $product, 'product');
        $product->update($data);
        // $product->name = $request->name;
        // $product->price = $request->price;
        // $product->new = $request->new;
        // $product->hit = $request->hit;
        // $product->sale = $request->sale;
        // $product->category_id = $request->category_id;
        // $product->collection_id = $request->collection_id;
        // $product->content = $request->content;
        // if ($request->image) $product->image = $this->imageSaver->upload($request, null, 'product');
        // $product->update();

        return redirect()
            ->route('user.product.edit', ['product' => $product->id])
            ->with('success', 'Товар был успешно обновлен');
    }

    /**
     * Удаляет товар каталога из базы данных
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product) {
        $this->imageSaver->remove($product, 'product');
        $product->delete();
        return redirect()
            ->route('user.product.index')
            ->with('success', 'Товар каталога успешно удален');
    }
}