<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/product/{id}', [PageController::class, 'product'])->name('product');
Route::post('/cart/add/{product}', [CartController::class, 'addItemToCart'])->name('add-to-cart');

Route::middleware(['guest'])->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'postLogin'])->name('login');
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'postRegister'])->name('register');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('profile', [PageController::class, 'profile'])->name('profile');
    Route::get('wishlist', [PageController::class, 'wishlist'])->name('wishlist');
    Route::get('cart', [PageController::class, 'cart'])->name('cart');

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('admin', [AdminController::class, 'admin'])->name('admin');

    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::get('categories.index/{category?}', [CategoryController::class, 'index'])->name('categories.index');
        Route::resource('colors', ColorController::class);
        Route::get('colors.index/{color?}', [ColorController::class, 'index'])->name('colors.index');
    });
});
