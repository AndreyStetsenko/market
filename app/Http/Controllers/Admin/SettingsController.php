<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\User;
use App\Models\Collection;
use App\Models\Category;
use App\Models\Attachment;
use App\Models\Attachmentable;
use App\Models\Order;
use App\Models\OrderItem;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function clearProducts(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        if ( Product::truncate() ) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return back()->with('success', 'Товары успещшо уничтожены');
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return back()->with('error', 'Ошибка уничтожения товаров');
    }

    public function clearImages(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        if ( Attachment::truncate() && Attachmentable::truncate() ) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return back()->with('success', 'Картинки успешно уничтожены');
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return back()->with('error', 'Ошибка уничтожения картинок');
    }

    public function clearOrders(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        if ( Order::truncate() && OrderItem::truncate() ) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return back()->with('success', 'Ордеры успешно уничтожены');
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return back()->with('error', 'Ошибка уничтожения ордеров');
    }
}
