<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class,'index'])->name('home');
Route::get('cart', [PageController::class,'cart'])->name('cart');

// Auth
Route::middleware(['guest'])->group(function () {
    Route::get('login', [AuthController::class,'login'])->name('login');
    Route::post('login', [AuthController::class,'postLogin'])->name('login');
    Route::get('register', [AuthController::class,'register'])->name('register');
    Route::post('register', [AuthController::class,'postRegister'])->name('register');
});

Route::group(['middleware' => 'auth'], function () {
    // Authenticated Routes Here
    Route::post('logout', [AuthController::class,'logout'])->name('logout');
    Route::get('admin', [AdminController::class,'admin'])->name('admin');

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
});
