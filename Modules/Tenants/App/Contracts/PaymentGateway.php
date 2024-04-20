<?php
/*
 * seo-api | PaymentGateway.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 4/18/2024 3:38 PM
*/

namespace Modules\Tenants\App\Contracts;


interface PaymentGateway
{
    public function charge($amount);

    public function refund($transactionId);
}
