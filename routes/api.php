<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\ConfigurationController;
use App\Http\Controllers\Api\CurrencyExchangeController;
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

Route::post('login', [AuthenticationController::class, 'login'])->name('api_login');
Route::get('logout', [AuthenticationController::class, 'logout'])->name('api_logout');

Route::middleware('auth:api')->group(function() {
    Route::post('configuration', [ConfigurationController::class, 'store'])->name('api_configuration_store');

    Route::post('exchange', [CurrencyExchangeController::class, 'getExchange'])->name('api_get_exchange');
    Route::get('exchange/history', [CurrencyExchangeController::class, 'getExchangeHistory'])->name('api_get_exchange_history');
    Route::get('exchange/available', [CurrencyExchangeController::class, 'getDefaultAvailable'])->name('api_get_default_available');
});
