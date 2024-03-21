<?php

use Illuminate\Support\Facades\Route;
use Modules\Tenants\App\Http\Controllers\TenantsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([], function () {
    Route::resource('tenants', TenantsController::class)->names('tenants');
    Route::redirect('/old'  , '/new');
    Route::permanentRedirect('/old'  , '/new');
});
