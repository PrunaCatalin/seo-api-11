<?php
/*
 * seo-api | subscription.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 3/29/2024 12:30 PM
*/

use Modules\Tenants\App\Http\Controllers\Subscription\SubscriptionPlansController;

Route::name('customer.')->group(function () {
    Route::get('plans', [SubscriptionPlansController::class, 'index'])->name('view.plans');
});
