<?php
/*
 * seo-api | CustomerCompanyService.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 5/3/2024 10:20 AM
*/

namespace Modules\Tenants\App\Services\Customer;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Tenants\App\Contracts\CrudMicroService;
use Modules\Tenants\App\Exceptions\ServiceException;
use Modules\Tenants\App\Models\Customer\Customer;

class CustomerCompanyService implements CrudMicroService
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
     * @return LengthAwarePaginator
     * @throws ServiceException
     */
    public function findAll(int $customerId, array $data)
    {
        $customer = Customer::find($customerId);
        if ($customer) {
            return $customer->customerCompanies()
                ->with('country')
                ->paginate(
                    perPage: $data['perPage'] ?? 10,
                    pageName: 'customerCompanies',
                    page: $data['page'] ?? 1
                );
        } else {
            throw new ServiceException('Customer is not found', []);
        }
    }
}
