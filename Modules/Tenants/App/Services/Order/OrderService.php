<?php
/*
 * seo-api | OrderService.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 4/27/2024 9:39 AM
*/

namespace Modules\Tenants\App\Services\Order;

use Modules\Tenants\App\Contracts\CrudMicroService;
use Modules\Tenants\App\Enums\Order\OrderStatus;
use Modules\Tenants\App\Models\Customer\Customer;
use Modules\Tenants\App\Models\Order\Order;

class OrderService implements CrudMicroService
{

    public function create(array $data)
    {
        if (isset($data['customer_id']) && is_numeric($data['customer_id'])) {
        }
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
     * @param Customer|null $customer
     * @return Order
     */
    public function totalStatsPending(?Customer $customer)
    {
        return Order::where(function ($q) use ($customer) {
            if ($customer) {
                $q->where('customer_id', $customer->id);
            }
            $q->where('status', OrderStatus::Pending);
        })->sum('amount');
    }

    /**
     * @param Customer|null $customer
     * @return Order
     */
    public function totalStatsCompleted(?Customer $customer)
    {
        return Order::where(function ($q) use ($customer) {
            if ($customer) {
                $q->where('customer_id', $customer->id);
            }
            $q->where('status', OrderStatus::Completed);
        })->sum('amount');
    }

    /**
     * @param Customer|null $customer
     * @return Order
     */
    public function totalStatsCancel(?Customer $customer)
    {
        return Order::where(function ($q) use ($customer) {
            if ($customer) {
                $q->where('customer_id', $customer->id);
            }
            $q->where('status', OrderStatus::Cancelled);
        })->sum('amount');
    }

}
