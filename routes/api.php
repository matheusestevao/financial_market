<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TransactionController;

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



Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::middleware('auth:api')->prefix('transaction')->controller(TransactionController::class)->group(function () {
    Route::get('list', 'list');
    Route::get('tickers', 'tickers');
    Route::get('prime_rate', 'prime_rate');
    Route::post('store', 'store');
});

/**
 * Route not Found
 */
Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found.'
    ], 404);
});