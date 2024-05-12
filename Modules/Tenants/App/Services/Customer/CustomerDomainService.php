<?php
/*
 * seo-api | CustomerDomainService.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 5/11/2024 9:54 PM
*/

namespace Modules\Tenants\App\Services\Customer;

use Modules\Tenants\App\Contracts\CrudMicroService;
use Modules\Tenants\App\Exceptions\ServiceException;
use Modules\Tenants\App\Models\Customer\Customer;
use Modules\Tenants\App\Models\Customer\CustomerDomain;

class CustomerDomainService implements CrudMicroService
{

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function update(array $data)
    {
        // TODO: Implement update() method.
    }

    public function delete(array $data)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ServiceException
     */
    public function findAllDomains(int $customerId)
    {
        return CustomerDomain::where('customer_id', $customerId)->get();
    }
}
