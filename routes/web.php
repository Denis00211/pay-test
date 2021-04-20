<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Auth;
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
Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::get('/payments/{id}', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
});

Route::get('/', static function () {
    return  redirect()->route('payments.index');
});

Route::get('/payments/pay/{uuid}', [PaymentController::class, 'payShow'])->name('payments.pay.show');

/**
 * Думаю лучше поменять на put(частично обновляем данные), пока оставил post запросом
 */
Route::post('/payments/pay/{uuid}', [PaymentController::class, 'pay'])->name('payments.pay');



