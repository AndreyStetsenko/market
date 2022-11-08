<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Order;
use Illuminate\Http\Request;
use Coinremitter\Coinremitter;
use Illuminate\Support\Facades\Http;
use Onetoweb\NOWPayments\Client as NOWPaymentsClient;
use App\Models\User;
use App\Models\Wallet;

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

        // Редирект на страницу подтверждения заказа
        return redirect()
            ->route('basket.success', $order->slug)
            ->with('order_id', $order->id);
    }

    /**
     * Сообщение об успешном оформлении заказа
     */
    public function success(Request $request, $order) {
        $status = Order::STATUSES;
        $order = Order::where('slug', $order)->firstOrFail();
        $order_id = $order->id;

        $resp_pay = Http::accept('application/json')->withHeaders([
            'x-api-key' => env('NOWPAYMENT_API_KEY'),
        ])->get( env('NOWPAYMENT_API_LINK') . '/v1/payment/' . $order->invoice);

        // if ( $resp_pay->payment_status )

        if ( auth()->check() ) {
            if ( $order->user_id == auth()->user()->id ) {
                return view('site.user.basket.success', compact('order', 'status', 'resp_pay'));
            } else {
                return redirect()->route('basket.index');
            }
        } else {
            if ($request->session()->exists('order_id')) {
                // сюда покупатель попадает сразу после оформления заказа
                $order_id = $request->session()->pull('order_id');
                $order = Order::findOrFail($order_id);
                return view('site.user.basket.success', compact('order', 'status', 'resp_pay'));
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

    public function payment(Request $request) {
        $response = Http::accept('application/json')->withHeaders([
            'x-api-key' => env('NOWPAYMENT_API_KEY'),
        ])->post( env('NOWPAYMENT_API_LINK') . '/v1/invoice', [
            "price_amount" => $request->amount,
            "price_currency" => "usd",
            "order_id" => $request->id,
            "ipn_callback_url" => env('NOWPAYMENT_WEBHOOK_URL'),
            "success_url" => route('basket.pay.success', $request->id),
            "cancel_url" => route('basket.pay.success', $request->id)
        ]);

        $resp = $response->json();

        $order = Order::find($request->id);
        $order->invoice = $resp['id'];
        $order->update();

        // dd($resp);
        return redirect($resp['invoice_url']);
    }

    public function response(Request $request) {
        // return response()->json($request);

        $payment_status = 1;

        switch ($request->payment_status) {
            case 'waiting':
                $payment_status = 1;
                break;

            case 'confirming':
                $payment_status = 1;
                break;

            case 'confirmed':
                $payment_status = 1;
                break;

            case 'sending':
                $payment_status = 1;
                break;

            case 'partially_paid':
                $payment_status = 1;
                break;

            case 'finished':
                $payment_status = 2;
                break;

            case 'failed':
                $payment_status = 6;
                break;

            case 'refunded':
                $payment_status = 6;
                break;

            case 'expired':
                $payment_status = 6;
                break;
            
            default:
                $payment_status = 1;
                break;
        }

        $order = Order::find($request->order_id);
        $order->status = $payment_status;
        $order->invoice = $request->payment_id;
        $order->update();
    }

    public function paySuccess($id) {
        $order = Order::find($id);

        return redirect()->route('basket.success', $order->slug);
    }

    public function cancel(Request $request) {
        dd($request);
    }

    public function fastPayment(Request $request)
    {
        $user = auth()->user();
        $recipient = User::find(1);
        $sum_transf = $request->amount * 100;

        $recipient_wallet_name = Wallet::where('holder_id', $recipient->id)->first();

        $my_wallet = $user->getWallet('usdt');
        $recipient_wallet = $recipient->getWallet('usdt');

        if ( $my_wallet->balance >= $sum_transf ) {
            $my_wallet->transfer($recipient_wallet, $sum_transf);

            $order = Order::find($request->id);
            $order->status = 2;
            $order->invoice = 0;
            $order->update();

            return redirect()->back();
        } else {
            return redirect()->back()->withErrors(['msg' => 'Insufficient funds on the balance sheet']);
        }
    }
}
