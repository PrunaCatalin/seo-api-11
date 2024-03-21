<?php

/*
 * wdirect-api | InfoValutarExchangeRateService.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : Javascript
 * Created on : 2/7/2024 9:39 AM
*/

namespace Modules\Tenants\App\Services\ExchangeService;

use Illuminate\Support\Facades\Http;
use Modules\Tenants\Contracts\ExchangeRate\IExchangeRateService;

class InfoValutarExchangeRateService implements IExchangeRateService
{
    /**
     * The URL to fetch exchange rates from BNR.
     *
     * @var string
     */
    protected string $url = 'http://www.infovalutar.ro/bnr/azi/';

    public function convertToRon(float $amount, string $currency)
    {
        $rate = $this->fetchExchangeRates($currency);
        return $amount * $rate;
    }

    /**
     * Fetch exchange rates from BNR.
     *
     * @return array Associative array of currency codes and their exchange rates to RON.
     */
    protected function fetchExchangeRates(string $currency): float
    {
        return (float)Http::get($this->url . $currency)->body();
    }
}
