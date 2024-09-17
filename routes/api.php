<?php

use Illuminate\Support\Facades\Route;
Use App\Http\Controllers\System\AuthController;
Use App\Http\Controllers\System\UserController;
use App\Http\Controllers\System\OrderController;
use App\Http\Controllers\System\IyataController;
use App\Http\Controllers\System\ClientController;
use App\Http\Controllers\System\ProductController;
use App\Http\Controllers\System\OrderDetailController;
use App\Http\Controllers\System\ProductPriceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('api')->group(function() {

    Route::controller(IyataController::class)
        ->prefix('iyata')
        ->as('iyata.')
        ->group(function () {

            Route::post('/algoritmia', 'algoritmia')->name('algoritmia');
            Route::post('/vuejs', 'vuejs')->name('vuejs');

        });

    Route::controller(AuthController::class)
        ->prefix('auth')
        ->as('auth.')
        ->group(function () {

            Route::post('/sanctum/token', 'login')->name('login');
            Route::middleware('auth:sanctum')
                ->post('/logout', 'logout')->name('logout');

        });

    Route::controller(UserController::class)
        ->prefix('user')
        ->as('user.')
        ->group(function () {

            Route::post('/register', 'register')->name('register');

        });

    Route::controller(ClientController::class)
        ->prefix('client')
        ->as('client.')
        ->group(function () {

            Route::post('/create', 'create')->name('create');
            Route::get('/get-items', 'getItems')->name('get-items');
            Route::get('/get-item', 'getItem')->name('get-items');
            Route::post('/update', 'update')->name('update');
            Route::post('/disable', 'disable')->name('disable');

        });

    Route::controller(ProductController::class)
        ->prefix('product')
        ->as('product.')
        ->group(function () {

            Route::post('/create', 'create')->name('create');
            Route::get('/get-items', 'getItems')->name('get-items');
            Route::get('/get-item', 'getItem')->name('get-item');
            Route::get('/get-item-code', 'getItemCode')->name('get-item-code');
            Route::post('/update', 'update')->name('update');
            Route::post('/disable', 'disable')->name('disable');

        });

    Route::controller(ProductPriceController::class)
        ->prefix('price')
        ->as('price.')
        ->group(function () {

            Route::post('/create', 'create')->name('create');
            Route::get('/get-items', 'getItems')->name('get-items');
            Route::get('/get-item', 'getItem')->name('get-item');
            Route::post('/update', 'update')->name('update');
            Route::post('/disable', 'disable')->name('disable');

        });

    Route::controller(OrderController::class)
        ->prefix('order')
        ->as('order.')
        ->group(function () {

            Route::post('/create', 'create')->name('create');
            Route::get('/get-items', 'getItems')->name('get-items');
            Route::get('/get-item', 'getItem')->name('get-item');
            Route::post('/update', 'update')->name('update');
            Route::post('/disable', 'disable')->name('disable');

        });

    Route::controller(OrderDetailController::class)
        ->prefix('order-detail')
        ->as('order-detail.')
        ->group(function () {

            Route::get('/get-order-items', 'getOrderItems')->name('get-order-items');

        });

});
