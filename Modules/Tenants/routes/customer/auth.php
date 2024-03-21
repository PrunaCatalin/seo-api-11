<?php

/**
 * File Name: auth.php
 * Author: CATALIN PRUNA
 * Created: 6/17/2023
 *
 * License:
 * --------------
 * SC WEBDIRECT TEHNOLOGIES SRL
 *
 * Change Log:
 * --------------
 * Date | Author | Description
 * 6/17/2023 | CATALIN PRUNA | Initial version
 *
 */


use Modules\Tenants\App\Http\Controllers\Customer\AuthController;
Route::prefix('auth/customer')->name('auth.customer.')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('action.login');
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('action.forgot_password');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('action.reset_password');
});
