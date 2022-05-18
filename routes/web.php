<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CurrencyExchangeController;
use App\Http\Controllers\ExchangeMailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', [AuthenticationController::class, 'login'])->name('login');
Route::post('submitLogin', [AuthenticationController::class, 'submitLogin'])->name('submit_login');
Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');

Route::middleware('auth:web')->group(function() {
    Route::get('/', [CurrencyExchangeController::class, 'index'])->name('index');
    Route::post('store', [CurrencyExchangeController::class, 'store'])->name('store');
    Route::post('submitMail', [ExchangeMailController::class, 'submitMail'])->name('submit_mail');
});
