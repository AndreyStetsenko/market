<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\User;

class TransactionsController extends Controller
{
    public function withStore(Request $request)
    {
        $user = auth()->user();
        $wallet = $user->wallet;

        if ($wallet->balance < ($request->sum2 * 100)) {
            return back()->with('error', 'Недостаточно денег на балансе');
        }

        if (($request->sum2 == 0) || ($request->sum2 < 0)) {
            return back()->with('error', 'Введите сумму больше 0');
        }
        
        $withdraw = $wallet->withdraw($request->sum2 * 100, null, false);

        $transaction = Transaction::where('uuid', $withdraw->uuid)->first();
        
        $transaction->is_withdraw = true;
        $transaction->method = $request->bank;
        $transaction->address = $request->card;
        $transaction->update();

        return back()->with('success', 'Заявка на вывод средств создана');
    }

    public function refillStore(Request $request)
    {
        $user = auth()->user();
        $wallet = $user->getWallet('usdt');
        $deposit = $wallet->deposit($request->sum1 * 100, null, false);
        return redirect()->route('user.refill.details', $deposit->uuid);
    }

    public function refillDetails(Request $request, $uuid)
    {
        $user = auth()->user();
        $item = Transaction::where('uuid', $uuid)->first();
        $statuses = Transaction::STATUSES;
        $amount = $item->amount / 100;
        $pay_status_cancel = 'cancel';
        $trans_link = '';

        // Generate Coinpayment Link
        if ($item->confirmed == 0) {
            $transaction['order_id'] = uniqid(); // invoice number
            $transaction['amountTotal'] = (FLOAT) $amount;
            $transaction['note'] = 'Transaction note';
            $transaction['buyer_name'] = $user->name;
            $transaction['buyer_email'] = $user->email;
            $transaction['redirect_url'] = url()->current() . '?pay=1'; // When Transaction was comleted
            $transaction['cancel_url'] = url()->current() . '?pay=' . $pay_status_cancel; // When user click cancel link

            $transaction['items'][] = [
                'itemDescription' => 'Product one',
                'itemPrice' => (FLOAT) $amount, // USD
                'itemQty' => (INT) 1,
                'itemSubtotalAmount' => (FLOAT) $amount // USD
            ];
        }

        if ($request->get('pay') == $pay_status_cancel) {
            $request->session()->flash('alert-danger', 'Transaction Canceled');
        }

        if ($request->get('pay') == 1 && $item->confirmed == 0) {
            $item->confirmed = 1;
            $item->update();

            $wallet = Wallet::find($item->wallet_id);
            $sum = $wallet->balance + $amount;
            $wallet->balance = $sum;
            $wallet->update();

            $request->session()->flash('alert-success', 'Transaction Success!');

            $user->getWallet($wallet->slug)->refreshBalance();
        }

        $statusMessage = $statuses[$item->confirmed];
        $statusCode = $item->confirmed;
        $statusColor = '';

        switch ($statusCode) {
            case '-1':
                $statusColor = 'danger';
                break;

            case '0':
                $statusColor = 'warning';
                break;

            case '1':
                $statusColor = 'success';
                break;
            
            default:
                $statusColor = 'success';
                break;
        }

        $typeArrow = '';

        switch ($item->type) {
            case 'deposit':
                $typeArrow = 'down';
                break;

            case 'withdraw':
                $typeArrow = 'up';
                break;
            
            default:
                $typeArrow = 'down';
                break;
        }

        return view('site.user.transactions.details', compact('item', 'statusMessage', 'statusCode', 'statusColor', 'typeArrow'));
    }

    public function cp(Request $request) {
        $private_key = env('CP_PRIVATE', '');
        $public_key = env('CP_PUBLIC', '');

        $transaction = Transaction::find($request->id);

        // Set the API command and required fields
        $req['version'] = 1;
        $req['cmd'] = 'create_transaction';
        $req['amount'] = $request->amount;
        $req['buyer_email'] = auth()->user()->email;
        $req['currency1'] = 'USDT.TRC20';
        $req['currency2'] = 'USDT.TRC20';
        $req['key'] = $public_key;
        $req['format'] = 'json'; //supported values are json and xml

        // Generate the query string
        $post_data = http_build_query($req, '', '&');

        // Calculate the HMAC signature on the POST data
        $hmac = hash_hmac('sha512', $post_data, $private_key);

        // Create cURL handle and initialize (if needed)
        static $ch = NULL;
        if ($ch === NULL) {
            $ch = curl_init('https://www.coinpayments.net/api.php');
            curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('HMAC: '.$hmac));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        // Execute the call and close cURL handle
        $data = curl_exec($ch);
        // $data = json_decode($data);
        // dd($data->result->qrcode_url);
        // Parse and return data if successful.
        if ($data !== FALSE) {
            if (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0') >= 0) {
                // We are on 32-bit PHP, so use the bigint as string option. If you are using any API calls with Satoshis it is highly NOT recommended to use 32-bit PHP
                $dec = json_decode($data, TRUE, 512, JSON_BIGINT_AS_STRING);
            } else {
                $dec = json_decode($data);

                $transaction->checkout_url = $dec->result->checkout_url;
                $transaction->status_url = $dec->result->status_url;
                $transaction->qrcode_url = $dec->result->qrcode_url;
                $transaction->txn_id = $dec->result->txn_id;
                $transaction->address = $dec->result->address;
                $transaction->confirms_needed = $dec->result->confirms_needed;
                $transaction->timeout = $dec->result->timeout;
                $transaction->update();
                // dd($dec->result);
                return redirect()->route('user.refill.pay', $transaction->uuid);
            }
            if ($dec !== NULL && count($dec)) {
                return $dec;
            } else {
                // If you are using PHP 5.5.0 or higher you can use json_last_error_msg() for a better error message
                return array('error' => 'Unable to parse JSON result ('.json_last_error().')');
            }
        } else {
            return array('error' => 'cURL error: '.curl_error($ch));
        }
    }

    public function pay(Request $request, $uuid) {
        $item = Transaction::where('uuid', $uuid)->first();
        $timeout = $item->timeout;

        return view('site.user.transactions.pay', compact('item'));
    }

    public function check(Request $request) {
        $private_key = env('CP_PRIVATE', '');
        $public_key = env('CP_PUBLIC', '');

        // Set the API command and required fields
        $req['version'] = 1;
        $req['cmd'] = 'get_tx_info';
        $req['txid'] = $request->txn_id;
        $req['key'] = $public_key;
        $req['full'] = 1;
        $req['format'] = 'json'; //supported values are json and xml

        // Generate the query string
        $post_data = http_build_query($req, '', '&');

        // Calculate the HMAC signature on the POST data
        $hmac = hash_hmac('sha512', $post_data, $private_key);

        // Create cURL handle and initialize (if needed)
        static $ch = NULL;
        if ($ch === NULL) {
            $ch = curl_init('https://www.coinpayments.net/api.php');
            curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('HMAC: '.$hmac));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        // Execute the call and close cURL handle
        $data = curl_exec($ch);
        // $data = json_decode($data);
        // dd($data->result->qrcode_url);
        // Parse and return data if successful.
        if ($data !== FALSE) {
            if (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0') >= 0) {
                // We are on 32-bit PHP, so use the bigint as string option. If you are using any API calls with Satoshis it is highly NOT recommended to use 32-bit PHP
                $dec = json_decode($data, TRUE, 512, JSON_BIGINT_AS_STRING);
            } else {
                $dec = json_decode($data);

                return response()->json($dec->result);
            }
            if ($dec !== NULL && count($dec)) {
                return $dec;
            } else {
                // If you are using PHP 5.5.0 or higher you can use json_last_error_msg() for a better error message
                return array('error' => 'Unable to parse JSON result ('.json_last_error().')');
            }
        } else {
            return array('error' => 'cURL error: '.curl_error($ch));
        }
    }

    public function update(Request $request) {
        $item = Transaction::find($request->id);
        $status = $request->status;

        $item->confirmed = $status;
        $item->update();

        return response()->json($status);
    }

    public function cancel(Request $request)
    {
        $private_key = env('CP_PRIVATE', '');
        $public_key = env('CP_PUBLIC', '');

        // Set the API command and required fields
        $req['cmd'] = 'cancel_withdrawal';
        $req['id'] = $request->txn_id;
        $req['key'] = $public_key;
        $req['format'] = 'json'; //supported values are json and xml

        // Generate the query string
        $post_data = http_build_query($req, '', '&');

        // Calculate the HMAC signature on the POST data
        $hmac = hash_hmac('sha512', $post_data, $private_key);

        // Create cURL handle and initialize (if needed)
        static $ch = NULL;
        if ($ch === NULL) {
            $ch = curl_init('https://www.coinpayments.net/api.php');
            curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('HMAC: '.$hmac));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        // Execute the call and close cURL handle
        $data = curl_exec($ch);
        // $data = json_decode($data);
        // dd($data->result->qrcode_url);
        // Parse and return data if successful.
        if ($data !== FALSE) {
            if (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0') >= 0) {
                // We are on 32-bit PHP, so use the bigint as string option. If you are using any API calls with Satoshis it is highly NOT recommended to use 32-bit PHP
                $dec = json_decode($data, TRUE, 512, JSON_BIGINT_AS_STRING);
            } else {
                $dec = json_decode($data);
                dd($dec->error);

                // if ($dec->error) return back();

                $item = Transaction::find($request->id);
                // $status = $request->status;
                $status = '-1';

                $item->confirmed = $status;
                $item->update();

                return back();
            }
            if ($dec !== NULL && count($dec)) {
                return $dec;
            } else {
                // If you are using PHP 5.5.0 or higher you can use json_last_error_msg() for a better error message
                return array('error' => 'Unable to parse JSON result ('.json_last_error().')');
            }
        } else {
            return array('error' => 'cURL error: '.curl_error($ch));
        }
    }
}
