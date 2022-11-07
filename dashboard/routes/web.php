<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payment\PaymentController;


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


// Route::get('dashboard/resume', [\App\Http\Controllers\PaymentController::class, 'resume'])->name('dashboard.resume');
// Route::get('dashboard/cancel', [\App\Http\Controllers\PaymentController::class, 'cancel'])->name('dashboard.cancel');
Route::get('dashboard/invoice/{invoice}', [\App\Http\Controllers\PaymentController::class, 'downloadInvoice'])->name('dashboard.invoice.download');
Route::get('dashboard/account', [\App\Http\Controllers\PaymentController::class, 'account'])->name('dashboard.account');
Route::get('/dashboard/checkout', [\App\Http\Controllers\PaymentController::class, 'checkout'])->name('dashboard.checkout');
Route::get('/dashboard/system', [\App\Http\Controllers\PaymentController::class, 'system'])->name('dashboard.system')->middleware((['subscribed']));
Route::post('dashboard/store', [\App\Http\Controllers\PaymentController::class, 'store'])->name('dashboard.store');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
