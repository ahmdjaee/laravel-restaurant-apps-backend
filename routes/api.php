<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(UserController::class)->group(function () {
    Route::post('/users/register', 'register');
    Route::post('/users/login', 'login');
});

Route::middleware(ApiAuthMiddleware::class)->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/users/current', 'current');
        Route::delete('/users/logout', 'logout');
    });

    Route::controller(ReservationController::class)->group(function () {
        Route::post('/reservations', 'reserve');
    });

    Route::controller(TableController::class)->group(function () {
        Route::get('/tables', 'getAll');
        Route::post('/tables', 'insert');
        Route::delete('/tables/{id}', 'delete');
        Route::put('/tables/{id}', 'update');
    });
});
