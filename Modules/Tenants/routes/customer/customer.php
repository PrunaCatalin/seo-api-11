<?php

/**
 * File Name: customer.php
 * Author: CATALIN PRUNA
 * Created: 7/9/2023
 *
 * License:
 * --------------
 * SC WEBDIRECT TEHNOLOGIES SRL
 *
 * Change Log:
 * --------------
 * Date| Author| Description
 * 7/9/2023 | CATALIN PRUNA | Initial version
 *
 */


use Modules\Tenants\App\Http\Controllers\Customer\CustomerController;
use Modules\Tenants\App\Http\Controllers\Customer\WalletController;

Route::name('customer.')->group(function () {
    //customer
    Route::get('details', [CustomerController::class, 'info'])->name('view.details');
    //Profile
    Route::patch('profile/update', [CustomerController::class, 'updateProfile'])->name('action.profileUpdate');
    Route::post('profile/addresses', [CustomerController::class, 'addresses'])->name('view.addresses');

    //contact
    Route::post('contact', [CustomerController::class, 'sendContact'])->name('action.contact');

    //wallet
    Route::get('wallet', [WalletController::class, 'index'])->name('view.wallet');
});
