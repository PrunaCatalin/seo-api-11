<?php

/*
 * wdirect-api | currency.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : Javascript
 * Created on : 2/2/2024 1:21 PM
*/


use Modules\Tenants\App\Http\Controllers\Currency\CurrencyController;

Route::middleware(['auth:sanctum'])->prefix('currency')->name('currency.')->group(function () {
    Route::post('convert', CurrencyController::class);
});
