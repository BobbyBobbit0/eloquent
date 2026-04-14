<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\User; // Added this

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    // Authenticated users: Customers, Products, Orders
    Route::resource('customers', CustomerController::class);
    Route::resource('products',  ProductController::class);
    Route::resource('orders',    OrderController::class);

    // Own account only
    Route::get('/account', [AccountController::class, 'show'])->name('account.show');

    // Admin only: Users management
    // Using User::class is cleaner than the full string
    Route::middleware('can:viewAny,' . User::class)->group(function () {
        Route::resource('users', UserController::class);
    });
});