<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Order;
use Illuminate\Http\Request;
use Coinremitter\Coinremitter;

class BasketController extends Controller {

    private $basket;

    public function __construct() {
        $this->basket = Basket::getBasket();
    }

    /**
     * Показывает корзину покупателя
     */
    public function index() {
        $products = $this->basket->products;
        $amount = $this->basket->getAmount();
        return view('site.user.basket.index', compact('products', 'amount'));
    }

    /**
     * Форма оформления заказа
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function checkout(Request $request) {
        $profile = null;
        $profiles = null;
        if (auth()->check()) { // если пользователь аутентифицирован
            $user = auth()->user();
            // ...и у него есть профили для оформления
            $profiles = $user->profiles;
            // ...и был запрошен профиль для оформления
            $prof_id = (int)$request->input('profile_id');
            if ($prof_id) {
                $profile = $user->profiles()->whereIdAndUserId($prof_id, $user->id)->first();
            }
        }
        return view('site.user.basket.checkout', compact('profiles', 'profile'));
    }

    /**
     * Возвращает профиль пользователя в формате JSON
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function profile(Request $request) {
        if ( ! $request->ajax()) {
            abort(404);
        }
        if ( ! auth()->check()) {
            return response()->json(['error' => 'Нужна авторизация!'], 404);
        }
        $user = auth()->user();
        $profile_id = (int)$request->input('profile_id');
        if ($profile_id) {
            $profile = $user->profiles()->whereIdAndUserId($profile_id, $user->id)->first();
            if ($profile) {
                return response()->json(['profile' => $profile]);
            }
        }
        return response()->json(['error' => 'Профиль не найден!'], 404);
    }

    /**
     * Сохранение заказа в БД
     */
    public function saveOrder(Request $request) {
        // проверяем данные формы оформления
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|max:255',
            'address' => 'required|max:255',
        ]);

        // Создание инвоиса на Coinremitter
        // $wallet = new Coinremitter($request->method);
        // $param = [
        //     'amount'=> $this->basket->getAmount(),      //required.
        //     'notify_url'=> 'https://the3.cloud', //optional,url on which you wants to receive notification,
        //     'fail_url' => route('basket.success'), //optional,url on which user will be redirect if user cancel invoice,
        //     'suceess_url' => route('basket.success'), //optional,url on which user will be redirect when invoice paid,
        //     'name'=>'',//optional,
        //     'currency'=>'usd',//optional,
        //     'expire_time'=>'30',//optional, invoice will expire in 30 minutes.
        //     'description'=>'Test',//optional.
        // ];
        // $invoice  = $wallet->create_invoice($param);

        $n = 64;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
    
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        // валидация пройдена, сохраняем заказ
        $user_id = auth()->check() ? auth()->user()->id : null;
        $order = Order::create(
            $request->all() 
            + [
                'slug' => $randomString,
                'amount' => $this->basket->getAmount(), 
                'user_id' => $user_id, 
                // 'invoice' => $invoice['data']['invoice_id']
                'invoice' => 0
                ]
        );

        foreach ($this->basket->products as $product) {
            $order->items()->create([
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $product->pivot->quantity,
                'cost' => $product->price * $product->pivot->quantity,
            ]);
        }

        // очищаем корзину
        $this->basket->clear();

        // $result = [
        //     'invoice_id'=>$order->invoice
        // ];
        // $invoice_result = $wallet->get_invoice($result);
        // $redirect_url = $invoice_result['data']['url'];

        // Редирект на мерчант
        // return redirect($redirect_url);

        // Редирект на страницу подтверждения заказа
        return redirect()
            ->route('basket.success', $order->slug)
            ->with('order_id', $order->id);
    }

    /**
     * Сообщение об успешном оформлении заказа
     */
    public function success(Request $request, $order) {
        $order = Order::where('slug', $order)->firstOrFail();
        $order_id = $order->id;

        if ( auth()->check() ) {
            if ( $order->user_id == auth()->user()->id ) {
                return view('site.user.basket.success', compact('order'));
            } else {
                return redirect()->route('basket.index');
            }
        } else {
            if ($request->session()->exists('order_id')) {
                // сюда покупатель попадает сразу после оформления заказа
                $order_id = $request->session()->pull('order_id');
                $order = Order::findOrFail($order_id);
                return view('site.user.basket.success', compact('order'));
            } else {
                // если покупатель попал сюда не после оформления заказа
                return redirect()->route('basket.index');
            }
        }
    }

    public function fail(Request $request) {
        return redirect()->route('basket.index');
    }

    /**
     * Добавляет товар с идентификатором $id в корзину
     */
    public function add(Request $request, $id) {
        $quantity = $request->input('quantity') ?? 1;
        $this->basket->increase($id, $quantity);
        if ( ! $request->ajax()) {
            // выполняем редирект обратно на ту страницу,
            // где была нажата кнопка «В корзину»
            return back();
        }
        // в случае ajax-запроса возвращаем html-код корзины в правом
        // верхнем углу, чтобы заменить исходный html-код, потому что
        // теперь количество позиций будет другим
        $positions = $this->basket->products()->count();
        return view('basket.part.basket', compact('positions'));
    }

    /**
     * Увеличивает кол-во товара $id в корзине на единицу
     */
    public function plus($id) {
        $this->basket->increase($id);
        // выполняем редирект обратно на страницу корзины
        return redirect()->route('basket.index');
    }

    /**
     * Уменьшает кол-во товара $id в корзине на единицу
     */
    public function minus($id) {
        $this->basket->decrease($id);
        // выполняем редирект обратно на страницу корзины
        return redirect()->route('basket.index');
    }

    /**
     * Удаляет товар с идентификаторм $id из корзины
     */
    public function remove($id) {
        $this->basket->remove($id);
        // выполняем редирект обратно на страницу корзины
        return redirect()->route('basket.index');
    }

    /**
     * Полностью очищает содержимое корзины покупателя
     */
    public function clear() {
        $this->basket->delete();
        // выполняем редирект обратно на страницу корзины
        return redirect()->route('basket.index');
    }
}
