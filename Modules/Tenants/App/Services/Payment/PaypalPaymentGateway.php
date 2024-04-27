<?php
/*
 * seo-api | PaypalPaymentGateway.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 4/18/2024 3:41 PM
*/

namespace Modules\Tenants\App\Services\Payment;

use Modules\Tenants\App\Contracts\PaymentGateway;
use Modules\Tenants\App\Contracts\PaymentProvider;
use Modules\Tenants\App\Models\Customer\Customer;
use Modules\Tenants\App\Models\Subscription\SubscriptionPlan;

class PaypalPaymentGateway implements PaymentProvider
{

    public function charge($amount)
    {
        // TODO: Implement charge() method.
    }

    public function refund($transactionId)
    {
        // TODO: Implement refund() method.
    }

    public function processPayment($requestData, Customer $customer, SubscriptionPlan $subscriptionPlan)
    {
        // TODO: Implement processPayment() method.
    }
}
