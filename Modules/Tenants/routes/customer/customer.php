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
Route::name('customer.')->group(function () {
    Route::post('contact', [CustomerController::class, 'sendContact'])->name('action.contact');
});
