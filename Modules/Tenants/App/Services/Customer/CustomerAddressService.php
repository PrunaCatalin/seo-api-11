<?php
/*
 * seo-api | CustomerAddress.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 4/15/2024 10:03 PM
*/

namespace Modules\Tenants\App\Services\Customer;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Tenants\App\Contracts\CrudMicroService;
use Modules\Tenants\App\Exceptions\ServiceException;
use Modules\Tenants\App\Models\Customer\Customer;
use Modules\Tenants\App\Models\Customer\CustomerAddress;

class CustomerAddressService implements CrudMicroService
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
            return $customer->customerAddresses()
                ->paginate(
                    perPage: $data['perPage'] ?? 10,
                    pageName: 'customerAddress',
                    page: $data['page'] ?? 1
                );
        } else {
            throw new ServiceException('Customer is not found', []);
        }
    }
}
