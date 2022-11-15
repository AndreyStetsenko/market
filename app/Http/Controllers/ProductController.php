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
use App\Models\BuyedUserProduct;
use App\Models\Basket;
use App\Models\Attachment;
use App\Models\Attachmentable;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    private $imageSaver;

    public function __construct(ImageSaver $imageSaver) {
        $this->imageSaver = $imageSaver;
        $this->basket = Basket::getBasket();
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
    public function store(Request $request) {        

        $request->merge([
            'new' => $request->has('new'),
            'hit' => $request->has('hit'),
            'sale' => $request->has('sale'),
        ]);
        $data = $request->all();
        // $data['image'] = $this->imageSaver->upload($request, null, 'product');
        $data['image'] = 'avatar.jpeg';
        $product = Product::create($data);

        if($request->hasfile('filename'))
         {

            foreach($request->file('filename') as $image)
            {
                $name = $image->getClientOriginalName();
                $dir = 'product';

                $source = $image;
                if ($source) { // если было загружено изображение
                    // перед загрузкой нового изображения удаляем старое
                    $ext = $source->extension();
                    // сохраняем загруженное изображение без всяких изменений
                    $path = $source->store('catalog/'.$dir.'/source', 'public');
                    $path = Storage::disk('public')->path($path); // абсолютный путь
                    $name = basename($path); // имя файла
                    // создаем уменьшенное изображение 600x300px, качество 100%
                    $dst = 'catalog/'.$dir.'/image/';
                    $this->resize($path, $dst, 600, 300, $ext);
                    // создаем уменьшенное изображение 300x150px, качество 100%
                    $dst = 'catalog/'.$dir.'/thumb/';
                    $this->resize($path, $dst, 300, 150, $ext);
                }

                $data_image[] = $name;

                $attachment = Attachment::create([
                    'name' => $name,
                    'sort' => 1,
                    'user_id' => auth()->user()->id
                ]);
        
                $attachmentable = Attachmentable::create([
                    'attachmentable_id' => $product->id,
                    'attachment_id' => $attachment->id
                ]);
            }
        }

        // $attachment = Attachment::create([
        //     'name' => json_encode($data_image),
        //     'sort' => 1,
        //     'user_id' => auth()->user()->id
        // ]);

        // $attachmentable = Attachmentable::create([
        //     'attachmentable_id' => $product->id,
        //     'attachment_id' => $attachment->id
        // ]);

        // if($request->hasFile('image'))
        // {
        // $images = $deal_item->images;
        // $files = $request->file('image');
        // foreach ($files as $file) {
        //     $extention = $file->getClientOriginalExtension();
        //     $fileNameToStore = 'deals/' . $deal_item->id . '/images/'.sha1_file($file).".".$extention;
        //     $path = $file->storeAs('public', $fileNameToStore);
        //     $images[] = "/storage/".$fileNameToStore;

        //     $attachment = Attachment::create([
        //         'name' => $fileNameToStore,
        //         'sort' => 1,
        //         'user_id' => auth()->user()->id
        //     ]);

        //     $attachmentable = Attachmentable::create([
        //         'attachmentable_id' => $product->id,
        //         'attachment_id' => $attachment->id
        //     ]);
        // }
        // $deal_item->images = $images;
        // }

        return redirect()
            ->route('catalog.product', ['product' => $product->slug])
            ->with('success', 'Новый товар успешно создан');
    }

    private function resize($src, $dst, $width, $height, $ext) {
        // создаем уменьшенное изображение width x height, качество 100%
        $image = Image::make($src)
            ->heighten($height)
            ->resizeCanvas($width, $height, 'center', false, 'eeeeee')
            ->encode($ext, 100);
        // сохраняем это изображение под тем же именем, что исходное
        $name = basename($src);
        Storage::disk('public')->put($dst . $name, $image);
        $image->destroy();
    }

    /**
     * Показывает страницу товара
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product) {
        $product_basket = $products = $this->basket->products->find($product->id);
        return view('user.product.show', compact('product', 'product_basket'));
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
            ->route('user.personal')
            ->with('success', 'Товар каталога успешно удален');
    }

    public function getProduct(Request $request, $id)
    {
        $user = auth()->user();
        $productBuy = BuyedUserProduct::where('buyer_id', $user->id)->where('product_id', $id)->first();
        $product = Product::find($productBuy->product_id);

        return response([
            'productBuy' => $productBuy,
            'product' => $product
        ]);
    }

    public function getProducts(Request $request)
    {
        $products = Product::all();

        return response()->json([
            'products' => $products
        ]);
    }
}
