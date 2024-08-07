<?php

use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ApiAuthMiddleware;
use App\Http\Middleware\EnsureUserIsAdmin;
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

Route::controller(EventController::class)->group(function () {
    Route::get('/events', 'getAll');
    Route::get('/events/{id}', 'get');
});

Route::get('/img/{path}', [ImageController::class, 'show'])
    ->where('path', '.*')
    ->name('image');

Route::middleware(ApiAuthMiddleware::class)->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/users/current', 'current');
        Route::delete('/users/logout', 'logout');
        Route::post('/users/update', 'update');
    });

    Route::controller(ReservationController::class)->group(function () {
        Route::post('/reservations', 'reserve');
        Route::put('/reservations/{id}', 'update')->where('id', '[0-9]+');
        Route::delete('/reservations/{id}', 'cancel')->where('id', '[0-9]+');
        Route::get('/reservations', 'get');
    });

    Route::controller(TableController::class)->group(function () {
        Route::get('/tables', 'getAll');
    });

    Route::controller(CartItemController::class)->group(function () {
        Route::get('/carts', 'getAll');
        Route::get('/carts/{id}', 'get');
        Route::post('/carts', 'store');
        Route::delete('/carts/{id}', 'delete');
        Route::patch('/carts/{id}', 'update');
    });

    Route::controller(OrderController::class)->group(function () {
        Route::get('/orders/{id}', 'get');
        Route::get('/orders', 'getAll');
        Route::post('/orders', 'order');
        Route::post('/orders/{id}/success', 'success');
    });
});


// Admin routes
Route::middleware([ApiAuthMiddleware::class, EnsureUserIsAdmin::class])->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/admin/users', 'getAll');
        Route::delete('/admin/users/{id}', 'delete');
    });

    Route::controller(MenuController::class)->group(function () {
        Route::post('/admin/menus', 'create');
        Route::post('/admin/menus/{id}', 'update');
        Route::delete('/admin/menus/{id}', 'delete');
    });

    Route::controller(EventController::class)->group(function () {
        Route::post('/admin/events', 'create');
        Route::post('/admin/events/{id}', 'update');
        Route::delete('/admin/events/{id}', 'delete');
    });

    Route::controller(TableController::class)->group(function () {
        Route::post('/admin/tables', 'create');
        Route::get('/admin/tables/{id}', 'get')->where('id', '[0-9]+');
        Route::delete('/admin/tables/{id}', 'delete')->where('id', '[0-9]+');
        Route::put('/admin/tables/{id}', 'update')->where('id', '[0-9]+');
    });

    Route::controller(CategoryController::class)->group(function () {
        Route::post('/admin/categories', 'create');
        Route::post('/admin/categories/{id}', 'update')->where('id', '[0-9]+');
        Route::delete('/admin/categories/{id}', 'delete')->where('id', '[0-9]+');
    });

    Route::controller(OrderController::class)->group(function () {
        Route::get('/admin/orders', 'getAllAdmin');
    });

    Route::controller(ReservationController::class)->group(function () {
        Route::get('/admin/reservations', 'getAllAdmin');
    });
});
