<?php
/*
 * wdirect-api | Tenancy.php
 * https://www.webdirect.ro/
 * Copyright 2023 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 17:25
*/

namespace App\Services\Tenant;

use Stancl\Tenancy\Database\Models\Tenant;

class Tenancy
{
    protected $currentTenant;

    public function setTenant(Tenant $tenant)
    {
        $this->currentTenant = $tenant;
    }

    public function getTenant(): ?Tenant
    {
        return $this->currentTenant;
    }
}

