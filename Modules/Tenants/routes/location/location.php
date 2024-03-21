<?php
/**
 * File Name: location.php
 * Author: CATALIN PRUNA
 * Created: 7/11/2023
 *
 * License:
 * --------------
 * SC WEBDIRECT TEHNOLOGIES SRL
 *
 * Change Log:
 * --------------
 * Date         | Author         | Description
 * 7/11/2023 | CATALIN PRUNA | Initial version
 *
 */

use Modules\Tenants\App\Http\Controllers\Location\LocationController;

Route::prefix('location')->name('location.')->group(function () {
    Route::post('get-counties' , [LocationController::class , 'getCounties'])->name('get.counties');
    Route::post('get-cities' , [LocationController::class , 'getCities'])->name('get.cities');
    Route::get('get-all-counties' , [LocationController::class , 'getAllCounties'])->name('get.all-counties');
    Route::get('get-all-cities' , [LocationController::class , 'getAllCities'])->name('get.all-cities');
});
