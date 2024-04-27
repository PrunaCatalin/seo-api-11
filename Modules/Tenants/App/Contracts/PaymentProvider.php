<?php
/*
 * seo-api | PaymentProvider.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 4/27/2024 11:41 AM
*/

namespace Modules\Tenants\App\Contracts;


use Modules\Tenants\App\Models\Customer\Customer;
use Modules\Tenants\App\Models\Subscription\SubscriptionPlan;

interface PaymentProvider
{
    public function processPayment($requestData, Customer $customer, SubscriptionPlan $subscriptionPlan);
}
