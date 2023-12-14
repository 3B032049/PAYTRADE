<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminHomeController;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use App\Http\Controllers\CartItemsController;

use App\Http\Controllers\AdminUsersController;
use App\Http\Controllers\AdminProductsController;
use App\Http\Controllers\AdminPostsController;
use App\Http\Controllers\AdminAdminsController;


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

Route::get('/', [App\Http\Controllers\IndexController::class, 'index']);
Route::get('/home', [App\Http\Controllers\IndexController::class, 'index'])->name('home');
Route::get('products/search', [App\Http\Controllers\ProductController::class, 'search'])->name('products.search');
Route::get('products/{product}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
//登入
Auth::routes();

Route::group(['middleware' => 'user'], function () {
    Route::get('cartItems', [App\Http\Controllers\CartItemsController::class, 'index'])->name("cart_items.index");
    Route::get('cartItems/create', [App\Http\Controllers\CartItemsController::class, 'create'])->name("cart_items.create");
    Route::post('cartItems/{product}', [App\Http\Controllers\CartItemsController::class, 'store'])->name("cart_items.store");
//    Route::post('cartItems/{product}', [App\Http\Controllers\CartItemsController::class, 'store_show'])->name("cart_items.store_show");
    Route::get('cartItems/{cartItem}/edit', [App\Http\Controllers\CartItemsController::class, 'edit'])->name("cart_items.edit");
    Route::patch('cartItems/{cartItem}', [App\Http\Controllers\CartItemsController::class, 'update'])->name("cart_items.update");
    Route::delete('cartItems/{cartItem}', [App\Http\Controllers\CartItemsController::class, 'destroy'])->name("cart_items.destroy");
    Route::get('sellers/create', [App\Http\Controllers\SellersController::class, 'create'])->name("sellers.create");
   Route::post('sellers/{selller}/store', [App\Http\Controllers\SellersController::class, 'store'])->name("sellers.store");
});

Route::group(['middleware' => 'seller'], function () {
    Route::prefix('sellers')->name('sellers.')->group(function () {
        Route::get('/products', [App\Http\Controllers\SellerProductsController::class, 'index'])->name('products.index');
        Route::get('/products/create', [App\Http\Controllers\SellerProductsController::class, 'create'])->name('products.create');
        Route::post('/products', [App\Http\Controllers\SellerProductsController::class, 'store'])->name("products.store");
        Route::get('/products/{product}/edit', [App\Http\Controllers\SellerProductsController::class, 'edit'])->name("products.edit");
        Route::patch('/products/{product}', [App\Http\Controllers\SellerProductsController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [App\Http\Controllers\SellerProductsController::class, 'destroy'])->name("products.destroy");
    });
});

Route::group(['middleware' => 'admin'], function () {
    Route::prefix('admins')->name('admins.')->group(function () {
        Route::get('/', [AdminHomeController::class, 'index']);
        Route::get('/dashboard',[App\Http\Controllers\AdminHomeController::class,'index'])->name('dashboard');

        Route::get('/users',[App\Http\Controllers\AdminUsersController::class,'index'])->name('users.index');
        Route::get('/users/create',[App\Http\Controllers\AdminUsersController::class,'create'])->name('users.create');
        Route::post('/users', [App\Http\Controllers\AdminUsersController::class, 'store'])->name("users.store");
        Route::get('/users/{user}/edit', [App\Http\Controllers\AdminUsersController::class, 'edit'])->name("users.edit");
        Route::patch('/users/{user}',[App\Http\Controllers\AdminUsersController::class,'update'])->name('users.update');
        Route::delete('/users/{user}', [App\Http\Controllers\AdminUsersController::class, 'destroy'])->name("users.destroy");

        Route::get('/products',[App\Http\Controllers\AdminProductsController::class,'index'])->name('products.index');
        Route::get('/products/create',[App\Http\Controllers\AdminProductsController::class,'create'])->name('products.create');
        Route::post('/products', [App\Http\Controllers\AdminProductsController::class, 'store'])->name("products.store");
        Route::get('/products/{product}/edit', [App\Http\Controllers\AdminProductsController::class, 'edit'])->name("products.edit");
        Route::patch('/products/{product}',[App\Http\Controllers\AdminProductsController::class,'update'])->name('products.update');
        Route::delete('/products/{product}', [App\Http\Controllers\AdminProductsController::class, 'destroy'])->name("products.destroy");

        Route::get('/product_categories',[App\Http\Controllers\AdminProductCategoriesController::class,'index'])->name('product_categories.index');
        Route::get('/product_categories/create',[App\Http\Controllers\AdminProductCategoriesController::class,'create'])->name('product_categories.create');
        Route::post('/product_categories', [App\Http\Controllers\AdminProductCategoriesController::class, 'store'])->name("product_categories.store");
        Route::patch('/product_categories/{product_category}/statusOff', [App\Http\Controllers\AdminProductCategoriesController::class, 'statusOff'])->name("product_categories.statusOff");
        Route::patch('/product_categories/{product_category}/statusOn', [App\Http\Controllers\AdminProductCategoriesController::class, 'statusOn'])->name("product_categories.statusOn");
        Route::get('/product_categories/{product_category}/edit', [App\Http\Controllers\AdminProductCategoriesController::class, 'edit'])->name("product_categories.edit");
        Route::patch('/product_categories/{product_category}',[App\Http\Controllers\AdminProductCategoriesController::class,'update'])->name('product_categories.update');
        Route::delete('/product_categories/{product_category}', [App\Http\Controllers\AdminProductCategoriesController::class, 'destroy'])->name("product_categories.destroy");

        //公告路由
        Route::get('posts', [App\Http\Controllers\AdminPostsController::class, 'index'])->name("posts.index");
        Route::get('posts/create', [App\Http\Controllers\AdminPostsController::class, 'create'])->name("posts.create");
        Route::post('posts', [App\Http\Controllers\AdminPostsController::class, 'store'])->name("posts.store");
        Route::get('posts/{post}/edit', [App\Http\Controllers\AdminPostsController::class, 'edit'])->name("posts.edit");
        Route::patch('posts/{post}', [App\Http\Controllers\AdminPostsController::class, 'update'])->name("posts.update");
        Route::delete('posts/{post}', [App\Http\Controllers\AdminPostsController::class, 'destroy'])->name("posts.destroy");


        //管理員操作路由
        Route::get('/admins',[App\Http\Controllers\AdminAdminsController::class,'index'])->name('admins.index');
        Route::get('/admins/create',[App\Http\Controllers\AdminAdminsController::class,'create'])->name('admins.create');
        Route::get('/admins/create_selected/{id}',[App\Http\Controllers\AdminAdminsController::class,'create_selcted'])->name('admins.create_selected');
        Route::post('/admins', [App\Http\Controllers\AdminAdminsController::class, 'store'])->name("admins.store");
        Route::post('/admins', [App\Http\Controllers\AdminAdminsController::class, 'store_level'])->name("admins.store_level");
        Route::get('/admins/{admin}/edit', [App\Http\Controllers\AdminAdminsController::class, 'edit'])->name("admins.edit");
        Route::patch('/admins/{admin}',[App\Http\Controllers\AdminAdminsController::class,'update'])->name('admins.update');
        Route::delete('/admins/{admin}', [App\Http\Controllers\AdminAdminsController::class, 'destroy'])->name("admins.destroy");
    });
});


