<?php
/*
 * seo-api | StripeService.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 4/18/2024 5:57 PM
*/

namespace App\Services\Payment;

use Stripe\Collection;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class StripeService
{
    public function __construct(private StripeClient $stripeClient)
    {
        $this->stripeClient = new StripeClient(config('cashier.secret'));
    }

    /**
     * @throws ApiErrorException
     */
    public function getAllProducts(): Collection
    {
        return $this->stripeClient->prices->all(['active' => true, 'expand' => ['data.product']]);
    }

    /**
     * @param $period
     * @return string
     */
    public function convertPeriod($period)
    {
        return match ($period) {
            'month' => 'monthly',
            'year' => 'yearly',
            default => $period,
        };
    }
}
