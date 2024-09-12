<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
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

Route::controller(AuthController::class)->group(function () {
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

Route::post('/contact', [ContactController::class, 'send']);

Route::middleware('auth')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/users/current', 'current');
        Route::delete('/users/logout', 'logout');
        Route::post('/users/update', 'update');
    });

    Route::controller(ReservationController::class)->group(function () {
        Route::post('/reservations', 'reserve');
        Route::delete('/reservations/{id}', 'cancel')->where('id', '[0-9]+');
        Route::get('/reservations', 'get');
    });

    Route::controller(TableController::class)->group(function () {
        Route::get('/tables', 'getAll');
    });

    Route::controller(CartItemController::class)->group(function () {
        Route::get('/carts', 'getAll');
        Route::post('/carts', 'store');
        Route::delete('/carts/{id}', 'delete');
        Route::patch('/carts/{id}', 'update');
    });

    Route::controller(OrderController::class)->group(function () {
        Route::get('/orders/{id}', 'get');
        Route::get('/orders', 'getAll');
        Route::post('/orders', 'order');
        Route::post('/orders/{id}/success', 'success');
        Route::delete('/orders/{id}', 'delete');
    });
});

// Admin routes
Route::middleware(['auth', EnsureUserIsAdmin::class])->prefix('admin')->group(function () {
    // NOTE - Perbaiki endpoint ini nanti
    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'getAll');
        Route::delete('/users/{id}', 'delete');
        Route::get('/users/summary', 'summary');
        Route::post('/users/create', 'create');
        Route::post('/users/{id}/update', 'update');
    });

    Route::controller(MenuController::class)->group(function () {
        Route::post('/menus', 'create');
        Route::post('/menus/{id}', 'update');
        Route::delete('/menus/{id}', 'delete');
        Route::get('/menus/summary', 'summary');
    });

    Route::controller(EventController::class)->group(function () {
        Route::post('/events', 'create');
        Route::post('/events/{id}', 'update');
        Route::delete('/events/{id}', 'delete');
        Route::get('/events/summary', 'summary');
    });

    Route::controller(TableController::class)->group(function () {
        Route::post('/tables', 'create');
        Route::get('/tables/{id}', 'get')->where('id', '[0-9]+');
        Route::delete('/tables/{id}', 'delete')->where('id', '[0-9]+');
        Route::put('/tables/{id}', 'update')->where('id', '[0-9]+');
    });

    Route::controller(CategoryController::class)->group(function () {
        Route::post('/categories', 'create');
        Route::post('/categories/{id}', 'update')->where('id', '[0-9]+');
        Route::delete('/categories/{id}', 'delete')->where('id', '[0-9]+');
    });

    Route::controller(OrderController::class)->group(function () {
        Route::get('/orders', 'getAllAdmin');
        Route::get('/orders/summary', 'summary');
    });

    Route::controller(ReservationController::class)->group(function () {
        Route::get('/reservations', 'getAllAdmin');
        Route::put('/reservations/{id}', 'update')->where('id', '[0-9]+');
    });
});
