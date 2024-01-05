<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminHomeController;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use App\Http\Controllers\CartItemsController;

use App\Http\Controllers\AdminUsersController;
use App\Http\Controllers\AdminProductsController;
use App\Http\Controllers\AdminPostsController;
use App\Http\Controllers\AdminAdminsController;
use App\Http\Controllers\OrderController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

#首頁
//Route::get('/', function () {
//    return view ('index');
//});
/*
//email驗證提示
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
*/

Route::get('/', [App\Http\Controllers\IndexController::class, 'index']);
Route::get('/home', [App\Http\Controllers\IndexController::class, 'index'])->name('home');
Route::get('products/search', [App\Http\Controllers\ProductController::class, 'search'])->name('products.search');
Route::get('products/{product}/show', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
Route::get('products/by_category/{category_id}/show', [App\Http\Controllers\ProductController::class, 'by_category'])->name('products.by_category');
Route::get('products/by_category/search/{category_id}', [App\Http\Controllers\ProductController::class, 'by_category_search'])->name('products.by_category.search');
Route::get('products/by_seller/{seller_id}/shop', [App\Http\Controllers\ProductController::class, 'by_seller'])->name('products.by_seller');
Route::get('products/by_seller/{seller_id}/search', [App\Http\Controllers\ProductController::class, 'by_seller_search'])->name('products.by_seller.search');
Route::get('products/by_seller_and_category/{seller_id}/shop/{category_id}', [App\Http\Controllers\ProductController::class, 'by_seller_and_category'])->name('products.by_seller_and_category');
Route::get('products/by_seller_and_category/{seller_id}/shop/{category_id}/search', [App\Http\Controllers\ProductController::class, 'by_seller_and_category_search'])->name('products.by_seller_and_category.search');

Route::get('/posts', [App\Http\Controllers\PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}', [App\Http\Controllers\PostController::class, 'show'])->name('posts.show');
//登入
Auth::routes();

Route::group(['middleware' => 'user'], function () {
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/',[App\Http\Controllers\UsersController::class,'index'])->name('index');
        Route::patch('/{user}',[App\Http\Controllers\UsersController::class,'update'])->name('update');
    });
    Route::get('cartItems', [App\Http\Controllers\CartItemsController::class, 'index'])->name("cart_items.index");
    Route::get('cartItems/create', [App\Http\Controllers\CartItemsController::class, 'create'])->name("cart_items.create");
    Route::post('cartItems/{product}', [App\Http\Controllers\CartItemsController::class, 'store'])->name("cart_items.store");
    Route::post('cartItems/{product}/addToCart', [App\Http\Controllers\CartItemsController::class, 'addToCart'])->name("cart_items.addToCart");
    Route::patch('cart_items/{cart_item}/quantity_minus/a', [App\Http\Controllers\CartItemsController::class, 'quantity_minus'])->name("cart_items.quantity_minus");
    Route::patch('cart_items/{cart_item}/quantity_plus', [App\Http\Controllers\CartItemsController::class, 'quantity_plus'])->name("cart_items.quantity_plus");
//    Route::post('cartItems/{product}', [App\Http\Controllers\CartItemsController::class, 'store_show'])->name("cart_items.store_show");
    Route::get('cartItems/{cartItem}/edit', [App\Http\Controllers\CartItemsController::class, 'edit'])->name("cart_items.edit");
    Route::patch('cartItems/{cartItem}', [App\Http\Controllers\CartItemsController::class, 'update'])->name("cart_items.update");
    Route::delete('cartItems/{cartItem}', [App\Http\Controllers\CartItemsController::class, 'destroy'])->name("cart_items.destroy");


    Route::get('sellers/create', [App\Http\Controllers\SellersController::class, 'create'])->name("sellers.create");
    Route::post('sellers/{selller}/store', [App\Http\Controllers\SellersController::class, 'store'])->name("sellers.store");

    Route::get('orders', [App\Http\Controllers\OrderController::class, 'index'])->name("orders.index");
    Route::get('orders/create', [App\Http\Controllers\OrderController::class, 'create'])->name("orders.create");
    Route::get('orders/{order}/show', [App\Http\Controllers\OrderController::class, 'show'])->name("orders.show");
    Route::post('orders', [App\Http\Controllers\OrderController::class, 'store'])->name("orders.store");

    Route::GET('orders/payment/{orders}', [App\Http\Controllers\OrderController::class, 'payment'])->name("orders.payment");

    Route::post('orders/{store_card}', [App\Http\Controllers\OrderController::class, 'store_card'])->name("orders.store_card");
    Route::patch('orders/{order}', [App\Http\Controllers\OrderController::class, 'update'])->name("orders.update");
    Route::delete('orders/{order}', [App\Http\Controllers\OrderController::class, 'destroy'])->name("orders.destroy");
    Route::get('/products/create', [App\Http\Controllers\SellerProductsController::class, 'create'])->name('products.create');
    Route::post('/products', [App\Http\Controllers\SellerProductsController::class, 'store'])->name("products.store");
    Route::delete('/products/{product}', [App\Http\Controllers\SellerProductsController::class, 'destroy'])->name("products.destroy");

    Route::get('orders/{order}/payment', [App\Http\Controllers\OrderController::class, 'payment'])->name("orders.payment");
    Route::patch('orders/{order}/update_pay', [App\Http\Controllers\OrderController::class, 'update_pay'])->name("orders.update_pay");
    Route::patch('orders/{order}/cancel_order', [App\Http\Controllers\OrderController::class, 'cancel_order'])->name("orders.cancel_order");
    Route::patch('orders/{order}/complete_order', [App\Http\Controllers\OrderController::class, 'complete_order'])->name("orders.complete_order");
    Route::get('orders/filter', [App\Http\Controllers\OrderController::class, 'filter'])->name('orders.filter');
    Route::get('orders/comment/{order}', [App\Http\Controllers\OrderController::class, 'comment'])->name('orders.comment');
    Route::PATCH('orders/{order}/store_comment', [App\Http\Controllers\OrderController::class, 'store_comment'])->name("orders.store_comment");
    Route::get('orders/{order}/comment_edit', [App\Http\Controllers\OrderController::class, 'comment_edit'])->name('orders.comment_edit');
    Route::PATCH('orders/{order}/update_comment', [App\Http\Controllers\OrderController::class, 'update_comment'])->name("orders.update_comment");

});

Route::group(['middleware' => 'seller'], function () {
    Route::prefix('sellers')->name('sellers.')->group(function () {
        Route::get('/products', [App\Http\Controllers\SellerProductsController::class, 'index'])->name('products.index');
        Route::get('/products/search', [App\Http\Controllers\SellerProductsController::class, 'search'])->name('products.search');
        Route::get('/products/create', [App\Http\Controllers\SellerProductsController::class, 'create'])->name('products.create');
        Route::post('/products', [App\Http\Controllers\SellerProductsController::class, 'store'])->name("products.store");
        Route::get('/products/{product}/edit', [App\Http\Controllers\SellerProductsController::class, 'edit'])->name("products.edit");
        Route::patch('/products/{product}', [App\Http\Controllers\SellerProductsController::class, 'update'])->name('products.update');
        Route::patch('/products/{product}/reply', [App\Http\Controllers\SellerProductsController::class, 'reply'])->name('products.reply');
        Route::patch('/products/{product}/statusoff', [App\Http\Controllers\SellerProductsController::class, 'statusoff'])->name('products.statusoff');
        Route::patch('/products/{product}/statuson', [App\Http\Controllers\SellerProductsController::class, 'statuson'])->name('products.statuson');
        Route::delete('/products/{product}', [App\Http\Controllers\SellerProductsController::class, 'destroy'])->name("products.destroy");

        Route::get('/orders', [App\Http\Controllers\SellerOrdersController::class, 'index'])->name('orders.index');
        Route::get('/orders/search', [App\Http\Controllers\SellerOrdersController::class, 'search'])->name('orders.search');
        Route::get('/orders/show', [App\Http\Controllers\SellerOrdersController::class, 'show'])->name('orders.show');
        Route::get('/orders/{order}/edit', [App\Http\Controllers\SellerOrdersController::class, 'edit'])->name("orders.edit");
        Route::patch('/orders/{order}', [App\Http\Controllers\SellerOrdersController::class, 'update'])->name('orders.update');
        Route::patch('/orders/{order}/pass', [App\Http\Controllers\SellerOrdersController::class, 'pass'])->name('orders.pass');
        Route::patch('/orders/{order}/unpass', [App\Http\Controllers\SellerOrdersController::class, 'unpass'])->name('orders.unpass');
        Route::patch('/orders/{order}/transport', [App\Http\Controllers\SellerOrdersController::class, 'transport'])->name('orders.transport');
        Route::patch('/orders/{order}/arrive', [App\Http\Controllers\SellerOrdersController::class, 'arrive'])->name('orders.arrive');
        Route::patch('/orders/{order}/cancel', [App\Http\Controllers\SellerOrdersController::class, 'cancel'])->name('orders.cancel');
        Route::patch('/orders/{order}/notcancel', [App\Http\Controllers\SellerOrdersController::class, 'notcancel'])->name('orders.notcancel');
        Route::delete('/orders/{order}', [App\Http\Controllers\SellerOrdersController::class, 'destroy'])->name("orders.destroy");

        Route::get('/messages', [App\Http\Controllers\SellerOrderMessagesController::class, 'index'])->name('messages.index');
        Route::get('/messages/search', [App\Http\Controllers\SellerOrderMessagesController::class, 'search'])->name('messages.search');
        Route::get('/messages/{order}/edit', [App\Http\Controllers\SellerOrderMessagesController::class, 'edit'])->name("messages.edit");
        Route::patch('/messages/{message}', [App\Http\Controllers\SellerOrderMessagesController::class, 'update'])->name('messages.update');
        Route::delete('/messages/{message}', [App\Http\Controllers\SellerOrderMessagesController::class, 'destroy'])->name("messages.destroy");
    });
});

Route::group(['middleware' => 'admin'], function () {
    Route::prefix('admins')->name('admins.')->group(function () {
        # 一般管理員
        Route::get('/', [AdminHomeController::class, 'index']);
        Route::get('/dashboard',[App\Http\Controllers\AdminHomeController::class,'index'])->name('dashboard');

        Route::get('/users',[App\Http\Controllers\AdminUsersController::class,'index'])->name('users.index');
        Route::get('/users/search', [App\Http\Controllers\AdminUsersController::class, 'search'])->name('users.search');
        Route::get('/users/create',[App\Http\Controllers\AdminUsersController::class,'create'])->name('users.create');
        Route::post('/users', [App\Http\Controllers\AdminUsersController::class, 'store'])->name("users.store");
        Route::get('/users/{user}/edit', [App\Http\Controllers\AdminUsersController::class, 'edit'])->name("users.edit");
        Route::patch('/users/{user}',[App\Http\Controllers\AdminUsersController::class,'update'])->name('users.update');
        Route::delete('/users/{user}', [App\Http\Controllers\AdminUsersController::class, 'destroy'])->name("users.destroy");

        Route::get('/products',[App\Http\Controllers\AdminProductsController::class,'index'])->name('products.index');
        Route::get('/products/search', [App\Http\Controllers\AdminProductsController::class, 'search'])->name('products.search');
        Route::get('/products/create',[App\Http\Controllers\AdminProductsController::class,'create'])->name('products.create');
        Route::post('/products', [App\Http\Controllers\AdminProductsController::class, 'store'])->name("products.store");
        Route::get('/products/{product}/edit', [App\Http\Controllers\AdminProductsController::class, 'edit'])->name("products.edit");
        Route::get('/products/{product}/review',[App\Http\Controllers\AdminProductsController::class,'review'])->name('products.review');
        Route::patch('/products/{product}',[App\Http\Controllers\AdminProductsController::class,'update'])->name('products.update');
        Route::patch('/products/{product}/pass',[App\Http\Controllers\AdminProductsController::class,'pass'])->name('products.pass');
        Route::patch('/products/{product}/unpass',[App\Http\Controllers\AdminProductsController::class,'unpass'])->name('products.unpass');
        Route::delete('/products/{product}', [App\Http\Controllers\AdminProductsController::class, 'destroy'])->name("products.destroy");

        Route::get('/product_categories',[App\Http\Controllers\AdminProductCategoriesController::class,'index'])->name('product_categories.index');
        Route::get('/product_categories/search', [App\Http\Controllers\AdminProductCategoriesController::class, 'search'])->name('product_categories.search');
        Route::get('/product_categories/create',[App\Http\Controllers\AdminProductCategoriesController::class,'create'])->name('product_categories.create');
        Route::post('/product_categories', [App\Http\Controllers\AdminProductCategoriesController::class, 'store'])->name("product_categories.store");
        Route::patch('/product_categories/{product_category}/statusOff', [App\Http\Controllers\AdminProductCategoriesController::class, 'statusOff'])->name("product_categories.statusOff");
        Route::patch('/product_categories/{product_category}/statusOn', [App\Http\Controllers\AdminProductCategoriesController::class, 'statusOn'])->name("product_categories.statusOn");
        Route::get('/product_categories/{product_category}/edit', [App\Http\Controllers\AdminProductCategoriesController::class, 'edit'])->name("product_categories.edit");
        Route::patch('/product_categories/{product_category}',[App\Http\Controllers\AdminProductCategoriesController::class,'update'])->name('product_categories.update');
        Route::delete('/product_categories/{product_category}', [App\Http\Controllers\AdminProductCategoriesController::class, 'destroy'])->name("product_categories.destroy");

        #公告路由
        Route::get('/posts', [App\Http\Controllers\AdminPostsController::class, 'index'])->name("posts.index");
        Route::get('/posts/search', [App\Http\Controllers\AdminPostsController::class, 'search'])->name('posts.search');
        Route::get('/posts/create', [App\Http\Controllers\AdminPostsController::class, 'create'])->name("posts.create");
        Route::post('/posts', [App\Http\Controllers\AdminPostsController::class, 'store'])->name("posts.store");
        Route::patch('/posts/{post}/statusOff', [App\Http\Controllers\AdminPostsController::class, 'statusOff'])->name("posts.statusOff");
        Route::patch('/posts/{post}/statusOn', [App\Http\Controllers\AdminPostsController::class, 'statusOn'])->name("posts.statusOn");
        Route::get('/posts/{post}/edit', [App\Http\Controllers\AdminPostsController::class, 'edit'])->name("posts.edit");
        Route::patch('/posts/{post}', [App\Http\Controllers\AdminPostsController::class, 'update'])->name("posts.update");
        Route::delete('/posts/{post}', [App\Http\Controllers\AdminPostsController::class, 'destroy'])->name("posts.destroy");

        # 高階管理員
        Route::group(['middleware' => 'admin.high_level'], function () {
            Route::get('/sellers',[App\Http\Controllers\AdminSellersController::class,'index'])->name('sellers.index');
            Route::get('/sellers/search', [App\Http\Controllers\AdminSellersController::class, 'search'])->name('sellers.search');
            Route::get('/sellers/create',[App\Http\Controllers\AdminSellersController::class,'create'])->name('sellers.create');
            Route::patch('/sellers/{seller}/statusOn',[App\Http\Controllers\AdminSellersController::class,'statusOn'])->name('sellers.statusOn');
            Route::patch('/sellers/{seller}/statusOff',[App\Http\Controllers\AdminSellersController::class,'statusOff'])->name('sellers.statusOff');
            Route::post('/sellers', [App\Http\Controllers\AdminSellersController::class, 'store'])->name("sellers.store");
            Route::get('/sellers/{seller}/edit', [App\Http\Controllers\AdminSellersController::class, 'edit'])->name("sellers.edit");
            Route::patch('/sellers/{seller}/pass',[App\Http\Controllers\AdminSellersController::class,'pass'])->name('sellers.pass');
            Route::patch('/sellers/{seller}/unpass',[App\Http\Controllers\AdminSellersController::class,'unpass'])->name('sellers.unpass');
            Route::delete('/sellers/{seller}', [App\Http\Controllers\AdminSellersController::class, 'destroy'])->name("sellers.destroy");

            Route::get('/orders', [App\Http\Controllers\AdminOrdersController::class, 'index'])->name('orders.index');
            Route::get('/orders/search', [App\Http\Controllers\AdminOrdersController::class, 'search'])->name('orders.search');
            Route::get('/orders/{order}/info', [App\Http\Controllers\AdminOrdersController::class, 'show'])->name('orders.show');
            Route::patch('/orders/{order}', [App\Http\Controllers\AdminOrdersController::class, 'cancel'])->name("orders.cancel");

            //管理員操作路由
            Route::get('/admins',[App\Http\Controllers\AdminAdminsController::class,'index'])->name('admins.index');
            Route::get('/admins/search', [App\Http\Controllers\AdminAdminsController::class, 'search'])->name('admins.search');
            Route::get('/admins/create',[App\Http\Controllers\AdminAdminsController::class,'create'])->name('admins.create');
            Route::get('/admins/create_selected/{id}',[App\Http\Controllers\AdminAdminsController::class,'create_selcted'])->name('admins.create_selected');
            Route::post('/admins', [App\Http\Controllers\AdminAdminsController::class, 'store'])->name("admins.store");
            Route::post('/admins', [App\Http\Controllers\AdminAdminsController::class, 'store_level'])->name("admins.store_level");
            Route::get('/admins/{admin}/edit', [App\Http\Controllers\AdminAdminsController::class, 'edit'])->name("admins.edit");
            Route::patch('/admins/{admin}',[App\Http\Controllers\AdminAdminsController::class,'update'])->name('admins.update');
            Route::delete('/admins/{admin}', [App\Http\Controllers\AdminAdminsController::class, 'destroy'])->name("admins.destroy");
        });

        # 超級管理員
        Route::group(['middleware' => 'admin.super'], function () {
            Route::get('/moneys', [App\Http\Controllers\AdminMoneysController::class, 'index'])->name('moneys.index');
            Route::get('/moneys/search', [App\Http\Controllers\AdminMoneysController::class, 'search'])->name('moneys.search');

            Route::get('/settings',[App\Http\Controllers\AdminSettingsController::class,'index'])->name('settings.index');
        });
    });
});


