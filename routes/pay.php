<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index'); // اگر صفحه دکمه داری
Route::post('/payment/pay', [PaymentController::class, 'pay'])->name('payment.pay');
Route::post('payment/callback', [PaymentController::class, 'callback'])->withoutMiddleware(['web'])->name('payment.callback');

*/

/*
Route::middleware(['auth'])->group(function () {
    Route::get('/booklets/{booklet}', 'pages::role.index')->name('role.index')->middleware('role:super-admin');

    Route::get('/booklets/{booklet}', ShowBookletPage::class)->name('booklets.show');
    Route::get('/checkout/{order}', CheckoutPage::class)->name('checkout.show');
    Route::get('/payment/result/{order}', PaymentResultPage::class)->name('payment.result');

    Route::get('/my-orders', MyOrdersPage::class)->name('orders.my');
    Route::get('/my-orders/{order}', OrderShowPage::class)->name('orders.show');
});

*/

Route::livewire('/booklets/{booklet}', 'pages::booklets.show')->name('booklet.show');
