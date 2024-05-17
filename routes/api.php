<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
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
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('/categories', 'getAll');
    Route::get('/categories/{id}', 'get');
});

Route::controller(MenuController::class)->group(function () {
    Route::get('/menus', 'getAll');
    Route::get('/menus/{id}', 'get');
});

Route::middleware(ApiAuthMiddleware::class)->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/users/current', 'current');
        Route::delete('/users/logout', 'logout');
    });

    Route::controller(ReservationController::class)->group(function () {
        Route::post('/reservations', 'reserve');
        Route::put('/reservations/{id}', 'update')->where('id', '[0-9]+');
        Route::delete('/reservations/{id}', 'cancel')->where('id', '[0-9]+');
    });

    Route::controller(TableController::class)->group(function () {
        Route::get('/tables', 'getAll');
        Route::post('/tables', 'create');
        Route::get('/tables/{id}', 'get')->where('id', '[0-9]+');
        Route::delete('/tables/{id}', 'delete')->where('id', '[0-9]+');
        Route::put('/tables/{id}', 'update')->where('id', '[0-9]+');
    });

    Route::controller(CategoryController::class)->group(function () {
        Route::post('/categories', 'create');
        Route::put('/categories/{id}', 'update')->where('id', '[0-9]+');
        Route::delete('/categories/{id}', 'delete')->where('id', '[0-9]+');
    });
});
