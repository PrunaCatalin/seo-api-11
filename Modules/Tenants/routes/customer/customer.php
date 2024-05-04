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
    //Profile
    Route::get('profile/info', [CustomerController::class, 'info'])->name('view.info');
    Route::post('profile/addresses', [CustomerController::class, 'addresses'])->name('view.addresses');
    Route::post('profile/companies', [CustomerController::class, 'companies'])->name('view.companies');

    Route::patch('profile/update', [CustomerController::class, 'updateProfile'])->name('action.profileUpdate');

    //contact
    Route::post('contact', [CustomerController::class, 'sendContact'])->name('action.contact');

    //wallet
    Route::get('wallet', [WalletController::class, 'index'])->name('view.wallet');
});
