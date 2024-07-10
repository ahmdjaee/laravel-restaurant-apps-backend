<?php

use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ApiAuthMiddleware;
use Illuminate\Support\Facades\Route;

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

Route::controller(UserController::class)->group(function () {
    Route::post('/users/register', 'register');
    Route::post('/users/login', 'login');
    Route::post('/admin/login', 'loginAdmin');
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('/categories', 'getAll');
    Route::get('/categories/{id}', 'get');
});

Route::controller(MenuController::class)->group(function () {
    Route::get('/menus', 'getAll');
    Route::get('/menus/{id}', 'get');
});


Route::get('/img/{path}', [ImageController::class, 'show'])
    ->where('path', '.*')
    ->name('image');

Route::middleware(ApiAuthMiddleware::class)->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/users/current', 'current');
        Route::delete('/users/logout', 'logout');
        Route::post('/users/update', 'update');
        
        // Admin
        Route::get('/admin/users', 'getAll');
    });

    Route::controller(ReservationController::class)->group(function () {
        Route::post('/reservations', 'reserve');
        Route::put('/reservations/{id}', 'update')->where('id', '[0-9]+');
        Route::delete('/reservations/{id}', 'cancel')->where('id', '[0-9]+');
        // Route::get('/reservations/{id}', 'get')->where('id', '[0-9]+');
        Route::get('/reservations', 'get');
    });

    Route::controller(TableController::class)->group(function () {
        Route::get('/tables', 'getAll');
        Route::post('/tables', 'create');
        Route::get('/tables/{id}', 'get')->where('id', '[0-9]+');
        Route::delete('/tables/{id}', 'delete')->where('id', '[0-9]+');
        Route::put('/tables/{id}', 'update')->where('id', '[0-9]+');
    });

    Route::controller(CategoryController::class)->group(function () {
        Route::post('/admin/categories', 'create');
        Route::put('/admin/categories/{id}', 'update')->where('id', '[0-9]+');
        Route::delete('/admin/categories/{id}', 'delete')->where('id', '[0-9]+');
    });

    Route::controller(MenuController::class)->group(function () {
        // Only admin can do this action
        Route::post('/admin/menus', 'create');
        Route::put('/admin/menus/{id}', 'update');
        Route::delete('/admin/menus/{id}', 'delete');
    });

    Route::controller(CartItemController::class)->group(function () {
        Route::get('/carts', 'getAll');
        Route::get('/carts/{id}', 'get');
        Route::post('/carts', 'store');
        Route::delete('/carts/{id}', 'delete');
        Route::patch('/carts/{id}', 'update');
    });

    Route::controller(OrderController::class)->group(function () {
        // Route::get('/orders/{id}', 'show');
        Route::get('/orders', 'getAll');
        Route::post('/orders', 'order');
    });
});
