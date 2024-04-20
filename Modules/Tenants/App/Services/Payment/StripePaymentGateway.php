<?php
/*
 * seo-api | StripePaymentGateway.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 4/18/2024 3:40 PM
*/

namespace Modules\Tenants\App\Services\Payment;

use Modules\Tenants\App\Contracts\PaymentGateway;

class StripePaymentGateway implements PaymentGateway
{
    public function charge($amount)
    {
        // TODO
    }

    public function refund($transactionId)
    {
        // TODO
    }
}
