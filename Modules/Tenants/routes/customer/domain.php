<?php
/*
 * seo-api | domain.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 13:21
*/

use Modules\Tenants\App\Http\Controllers\Customer\DomainController;

Route::name('customer.domain.')->group(function () {
    Route::post('domains', [DomainController::class, 'domains'])->name('view.domains');
    Route::post('domain/add', [DomainController::class, 'createDomain'])->name('create.domain');
    Route::delete('domain/delete/{id}', [DomainController::class, 'deleteDomain'])->name('delete.domain');
});
