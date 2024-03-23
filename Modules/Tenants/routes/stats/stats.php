<?php

/*
 * seo-api | stats.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 3/22/2024 2:06 PM
*/

use Modules\Tenants\App\Http\Controllers\Stats\StatsController;

Route::name('stats.')->group(function () {
    Route::get('get-statistics', [StatsController::class, 'dashboard'])->name('view.statistic');
});
