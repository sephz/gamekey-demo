<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameKeyController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::prefix('v1')->name('api.v1.')->middleware('auth:sanctum')->group(function () {
Route::prefix('v1')->name('api.v1.')->group(function () {

    Route::controller(GameController::class)->name('game.')->prefix('game')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{game}', 'show')->name('show');
    });

    Route::controller(GameKeyController::class)->name('gamekey.')->prefix('gamekey')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
    });

    Route::controller(TransactionController::class)->name('transaction.')->prefix('transaction')->group(function () {
        Route::post('/', 'store')->name('store');
        Route::get('/{uuid}', 'show')->name('show');
    });

    Route::controller(AuthController::class)->name('user.')->prefix('user')->group(function () {
        Route::post('/login', 'login')->name('login');
    });
});

