<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\IndexController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\IndexController::class, 'index'])->name('home');

//Route::get('/', [App\Livewire\Shopping\Index::class,'render'])->name('livewire.shopping.index');
//登入
Auth::routes();


