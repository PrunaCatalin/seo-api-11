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

class PaypalPaymentGateway implements PaymentGateway
{

    public function charge($amount)
    {
        // TODO: Implement charge() method.
    }

    public function refund($transactionId)
    {
        // TODO: Implement refund() method.
    }
}
