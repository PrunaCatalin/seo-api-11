<?php
/*
 * seo-api | WalletService.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 3/28/2024 3:53 PM
*/

namespace Modules\Tenants\App\Services\Customer;

use Modules\Tenants\App\Contracts\CrudMicroService;
use Modules\Tenants\App\Exceptions\ServiceException;
use Modules\Tenants\App\Models\Customer\Customer;
use Modules\Tenants\App\Models\Customer\CustomerSubscriptionPlan;
use Modules\Tenants\App\Models\Subscription\SubscriptionPlan;

class WalletService implements CrudMicroService
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
     * @param Customer $customer
     * @return CustomerSubscriptionPlan
     */
    public function getWallet(Customer $customer): SubscriptionPlan
    {
        return $customer->currentPlan();
    }

    /**
     * Adds credits to the customer's account.
     *
     * @param Customer $customer
     * @param int $credits
     * @throws ServiceException
     */
    public function addCredits(Customer $customer, int $credits): void
    {
        if ($credits < 0) {
            throw new ServiceException('Credit amount must be positive.');
        }

        $customer->credits += $credits;
        $customer->save();
    }

    /**
     * Removes credits from the customer's account.
     *
     * @param Customer $customer
     * @param int $credits
     * @throws ServiceException
     */
    public function removeCredits(Customer $customer, int $credits): void
    {
        if ($credits < 0) {
            throw new ServiceException('Credit amount must be positive.');
        }

        if ($customer->credits < $credits) {
            throw new ServiceException('Insufficient credits.');
        }

        $customer->credits -= $credits;
        $customer->save();
    }
}
