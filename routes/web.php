<?php

use Illuminate\Support\Facades\Route;

use Victorybiz\LaravelCryptoPaymentGateway\Http\Controllers\CryptoPaymentController;
use App\Http\Controllers\Payment\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
 * Главная страница интернет-магазина
 */
Route::get('/', 'IndexController')->name('index');

/*
 * Страницы «Доставка», «Контакты» и прочие
 */
Route::get('/{page:slug}', 'PageController')->name('page.show');

/*
 * Каталог товаров: категория, бренд и товар
 */
Route::group([
    'as' => 'catalog.', // имя маршрута, например catalog.index
    'prefix' => 'catalog', // префикс маршрута, например catalog/index
], function () {
    // главная страница каталога
    Route::get('index', 'CatalogController@index')
        ->name('index');
    // категория каталога товаров
    Route::get('category/{category:slug}', 'CatalogController@category')
        ->name('category');
    // бренд каталога товаров
    Route::get('brand/{brand:slug}', 'CatalogController@brand')
        ->name('brand');
    // страница товара каталога
    Route::get('product/{product:slug}', 'CatalogController@product')
        ->name('product');
    // страница результатов поиска
    Route::get('search', 'CatalogController@search')
        ->name('search');
});

/*
 * Корзина покупателя
 */
Route::group([
    'as' => 'basket.', // имя маршрута, например basket.index
    'prefix' => 'basket', // префикс маршрута, например basket/index
], function () {
    // список всех товаров в корзине
    Route::get('index', 'BasketController@index')
        ->name('index');
    // страница с формой оформления заказа
    Route::get('checkout', 'BasketController@checkout')
        ->name('checkout');
    // получение данных профиля для оформления
    Route::post('profile', 'BasketController@profile')
        ->name('profile');
    // отправка данных формы для сохранения заказа в БД
    Route::post('saveorder', 'BasketController@saveOrder')
        ->name('saveorder');
    // страница после успешного сохранения заказа в БД
    Route::get('success/{order}', 'BasketController@success')
        ->name('success');
    Route::post('order/pay', 'BasketController@payment')
        ->name('payment');
    Route::post('order/fast-pay', 'BasketController@fastPayment')
        ->name('fast-payment');
    Route::post('order/pay/response', 'BasketController@response')
        ->name('pay.response');
    Route::get('order/pay/success/{id}', 'BasketController@paySuccess')
        ->name('pay.success');
    Route::get('order/pay/cancel', 'BasketController@cancel')
        ->name('pay.cancel');
    // страница ошибки заказа
    Route::get('fail', 'BasketController@fail')
        ->name('fail');
    // отправка формы добавления товара в корзину
    Route::post('add/{id}', 'BasketController@add')
        ->where('id', '[0-9]+')
        ->name('add');
    // отправка формы изменения кол-ва отдельного товара в корзине
    Route::post('plus/{id}', 'BasketController@plus')
        ->where('id', '[0-9]+')
        ->name('plus');
    // отправка формы изменения кол-ва отдельного товара в корзине
    Route::post('minus/{id}', 'BasketController@minus')
        ->where('id', '[0-9]+')
        ->name('minus');
    // отправка формы удаления отдельного товара из корзины
    Route::post('remove/{id}', 'BasketController@remove')
        ->where('id', '[0-9]+')
        ->name('remove');
    // отправка формы для удаления всех товаров из корзины
    Route::post('clear', 'BasketController@clear')
        ->name('clear');
});

/*
 * Регистрация, вход в ЛК, восстановление пароля
 */
Route::name('user.')->prefix('user')->group(function () {
    Auth::routes();
});

/*
 * Личный кабинет зарегистрированного пользователя
 */
Route::group([
    'as' => 'user.', // имя маршрута, например user.index
    'prefix' => 'user', // префикс маршрута, например user/index
    'middleware' => ['auth'] // один или несколько посредников
], function () {
    // Личный кабинет
    Route::get('index', 'UserController@index')->name('index'); // Главная страница личного кабинета пользователя
    Route::get('edit', 'UserController@edit')->name('edit');
    Route::post('update', 'UserController@update')->name('update');
    Route::get('personal', 'UserController@personal')->name('personal')->middleware('manager');
    Route::get('personal/collections', 'UserController@collections')->name('personal.collections')->middleware('manager');
    Route::get('personal/collection/{collection}', 'UserController@collectionProducts')->name('personal.collection');
    Route::get('personal/orders', 'UserController@orders')->name('personal.orders');
    // ***** / ***** //
    Route::get('personal/buy-products', 'UserController@buyProducts')->name('personal.buy-products'); // Купленные товары юзера
    Route::get('personal/sell-products', 'UserController@resellProducts')->name('personal.sell-products'); // Товары юзера выставленные на перепродажу
    Route::get('personal/sell-product/create/{slug}', 'UserController@resellProductCreate')->name('personal.sell-product.create'); // Создание заявки на перепродажу товара
    Route::post('personal/sell-product/store', 'UserController@resellProductStore')->name('personal.sell-product.store');
    Route::get('personal/sell-product/edit/{slug}', 'UserController@resellProductEdit')->name('personal.sell-product.edit'); // Редактирование заявки на перепродажу товара
    Route::post('personal/sell-product/update', 'UserController@resellProductUpdate')->name('personal.sell-product.update');

    // Referals
    Route::get('personal/referals', 'ReferalsController@userReferals')->name('personal.referals');

    // Options
    Route::get('option/create', 'UserController@option')->name('create.option')->middleware('manager');
    // CRUD-операции над профилями пользователя
    Route::resource('profile', 'ProfileController');
    // просмотр списка заказов в личном кабинете
    Route::get('order', 'OrderController@index')->name('order.index');
    // просмотр отдельного заказа в личном кабинете
    Route::get('order/{order}', 'OrderController@show')->name('order.show');
    // CRUD-операции над продуктами пользователя
    Route::resource('product', 'ProductController')->middleware('manager');
    // Route::post('product/{product}/update', 'ProductController@update')->name('product.update');
    // доп.маршрут для показа товаров категории
    Route::get('product/category/{category}', 'ProductController@category')
        ->name('product.category');
    // CRUD-операции над аккаунтом пользователя
    // Route::get('account', 'AccountController')->name('account.show');
    Route::get('collections', 'CollectionController@index')->name('collection.index');
    Route::get('collection/create', 'CollectionController@create')->name('collection.create')->middleware('manager');
    Route::get('collection/edit/{collection}', 'CollectionController@edit')->name('collection.edit')->middleware('manager');
    Route::post('collection/store', 'CollectionController@store')->name('collection.store');
    Route::post('collection/update/{collection}', 'CollectionController@update')->name('collection.update');

    // Wallet
    Route::get('wallet', 'WalletController@index')->name('wallet');

    // Transactions
    Route::post('withdraw/store', 'TransactionsController@withStore')->name('withdraw.store');
    Route::post('refill/store', 'TransactionsController@refillStore')->name('refill.store');
    Route::get('refill/details/{uuid}', 'TransactionsController@refillDetails')->name('refill.details');
    Route::post('refill/cp', 'TransactionsController@cp')->name('refill.cp');
    Route::get('refill/pay/{uuid}', 'TransactionsController@pay')->name('refill.pay');
    Route::post('refill/check', 'TransactionsController@check')->name('refill.check');
    Route::post('refill/update', 'TransactionsController@update')->name('refill.update');
    Route::post('refill/cancel', 'TransactionsController@cancel')->name('refill.cancel');
});

Route::get('collection/{collection}', 'CollectionController@show')->name('collection.show');

/*
 * Панель управления магазином для администратора сайта
 */
Route::group([
    'as' => 'admin.', // имя маршрута, например admin.index
    'prefix' => 'admin', // префикс маршрута, например admin/index
    'namespace' => 'Admin', // пространство имен контроллера
    'middleware' => ['auth', 'admin'] // один или несколько посредников
], function () {
    // главная страница панели управления
    Route::get('index', 'IndexController')->name('index');
    // CRUD-операции над категориями каталога
    Route::resource('category', 'CategoryController');
    // CRUD-операции над брендами каталога
    Route::resource('brand', 'BrandController');
    // CRUD-операции над товарами каталога
    Route::resource('product', 'ProductController');
    // доп.маршрут для показа товаров категории
    Route::get('product/category/{category}', 'ProductController@category')
        ->name('product.category');
    // просмотр и редактирование заказов
    Route::resource('order', 'OrderController', ['except' => [
        'create', 'store', 'destroy'
    ]]);
    // просмотр и редактирование пользователей
    Route::resource('user', 'UserController', ['except' => [
        'create', 'store', 'show', 'destroy'
    ]]);
    // CRUD-операции над страницами сайта
    Route::resource('page', 'PageController');
    // загрузка изображения из wysiwyg-редактора
    Route::post('page/upload/image', 'PageController@uploadImage')
        ->name('page.upload.image');
    //  Добавление кастомных полей
    Route::post('page/add/custom-field', 'PageController@addCustom')
        ->name('page.custom.add');
    Route::post('page/add/custom-fields', 'PageController@addCustomFields')
        ->name('page.custom-field.add');
    Route::post('page/remove/custom-fields/{id}', 'PageController@removeCustomFields')
        ->name('page.custom-field.remove');
    // удаление изображения в wysiwyg-редакторе
    Route::delete('page/remove/image', 'PageController@removeImage')
        ->name('page.remove.image');

    // Рефералка
    Route::get('referr', 'ReferralController@index')->name('referr.index');
    Route::post('referr/store', 'ReferralController@store')->name('referr.store');

    Route::get('withdraws', 'WithdrawsAdminController@withdraws')->name('withdraws');
    Route::post('withdraws/success', 'WithdrawsAdminController@withdrawSuccess')->name('withdraw.success');

    // Settings
    Route::get('settings', 'SettingsController@index')->name('settings');
    Route::post('settings/clear/products', 'SettingsController@clearProducts')->name('settings.clear.products');
    Route::post('settings/clear/users', 'SettingsController@clearUsers')->name('settings.clear.users');
    Route::post('settings/clear/collection', 'SettingsController@clearCollection')->name('settings.clear.collection');
    Route::post('settings/clear/categories', 'SettingsController@clearCategories')->name('settings.clear.categories');
    Route::post('settings/clear/images', 'SettingsController@clearImages')->name('settings.clear.images');
    Route::post('settings/clear/orders', 'SettingsController@clearOrders')->name('settings.clear.orders');
});

Route::get('user/{user}', 'UserController@profile')
        ->name('user.profile');

// API (недоапи)
Route::get('pitem/{id}', 'ProductController@getProduct')
    ->name('product.get');
Route::get('products/get', 'ProductController@getProducts')
    ->name('products.get');

// Payments
// Route::match(['get', 'post'], '/payments/crypto/pay', [CryptoPaymentController::class])
//                 ->name('payments.crypto.pay');

// Route::post('/payments/crypto/callback', [PaymentController::class, 'callback'])
//                 ->withoutMiddleware(['web', 'auth']);