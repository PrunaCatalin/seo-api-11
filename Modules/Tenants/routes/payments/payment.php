<?php
/*
 * seo-api | payment.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 4/18/2024 1:14 PM
*/

//payments/stripe/webhook
use Modules\Tenants\App\Http\Controllers\Customer\CustomerController;
use Modules\Tenants\App\Http\Controllers\PaymentController\PaymentController;

Route::name('payment.')->group(function () {
    Route::post('/checkout', [PaymentController::class, 'checkout'])->name('action.checkout');

    Route::get('stripe/payment_id/{id}', [PaymentController::class, 'getPayment'])->name('view.payment');
    Route::post('stripe/webhook', [CustomerController::class, 'info'])->name('action.webhook');
});
