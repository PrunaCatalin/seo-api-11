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

use App\Services\Tenant\Tenancy;
use Illuminate\Support\Facades\Log;
use Modules\Tenants\App\Contracts\CrudMicroService;
use Modules\Tenants\App\Exceptions\ServiceException;
use Modules\Tenants\App\Models\Customer\Customer;
use Modules\Tenants\App\Models\Customer\CustomerDomain;
use Modules\Tenants\App\Models\Customer\CustomerDomainSettings;

class CustomerDomainService implements CrudMicroService
{

    public function update(array $data)
    {
        // TODO: Implement update() method.
    }

    /**
     * @throws ServiceException
     */
    public function createDomain(Customer $customer, string $domainName)
    {
        $domain = CustomerDomain::where('domain', $domainName)->first();

        if ($domain) {
            throw new ServiceException('Domain is already register!');
        } else {
            if ($customer->currentPlan()) {
                $countDomains = CustomerDomain::where('customer_id', $customer->id)->count();
                if ($countDomains < $customer->currentPlan()->max_domains) {
                    $customerDomain = CustomerDomain::create(
                        [
                            'domain' => $domainName,
                            'customer_id' => $customer->id,
                            'tenant_id' => $customer->tenant_id
                        ]
                    );
                    CustomerDomainSettings::create([
                        'customer_id' => $customer->id,
                        'customer_domains_id' => $customerDomain->id,
                        'countries' => [],
                        'links' => [],
                        'keywords' => []
                    ]);
                    return $customerDomain;
                } else {
                    throw new ServiceException('You already reach max number of domains!');
                }
            } else {
                throw new ServiceException('You need to have a subscription plan active!');
            }
        }

    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    /**
     * @throws ServiceException
     */
    public function deleteDomain(Customer $customer, int $domainId)
    {
        $domain = CustomerDomain::find($domainId);
        if ($domain) {
            if ($customer->expiredPlan() || $customer->canceledByClientPlan() || $customer->canceledPlan()) {
                $domain->domainSettings()->delete();
                return $domain->delete();
            } else {
                throw new ServiceException(
                    'You can\'t delete this domain until current subscription is canceled / expired!'
                );
            }
        } else {
            throw new ServiceException('Domain not found!');
        }
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
