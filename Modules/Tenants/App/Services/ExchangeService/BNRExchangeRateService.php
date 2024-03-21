<?php

/*
 * wdirect-api | BNRExchangeRateService.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : Javascript
 * Created on : 2/2/2024 12:43 PM
*/

namespace Modules\Tenants\App\Services\ExchangeService;

use Illuminate\Support\Facades\Http;
use Modules\Tenants\Contracts\ExchangeRate\IExchangeRateService;

class BNRExchangeRateService implements IExchangeRateService
{
    /**
     * The URL to fetch exchange rates from BNR.
     *
     * @var string
     */
    protected string $url = 'https://www.bnr.ro/nbrfxrates.xml';

    /**
     * Fetch exchange rates from BNR and convert a given amount from a specified currency to RON.
     *
     * @param float $amount The amount to be converted.
     * @param string $currency The currency code of the amount (e.g., USD, EUR).
     * @return float|null The converted amount in RON or null if conversion cannot be performed.
     */
    public function convertToRon(float $amount, string $currency): ?float
    {
        $rates = $this->fetchExchangeRates();

        // Check if the currency is supported
        if (!array_key_exists($currency, $rates)) {
            return null; // Currency isn't found
        }

        // Perform the conversion
        $rate = $rates[$currency];
        return $amount * $rate;
    }

    /**
     * Fetch exchange rates from BNR.
     *
     * @return array Associative array of currency codes and their exchange rates to RON.
     */
    protected function fetchExchangeRates(): array
    {
        $response = Http::get($this->url);
        $xml = simplexml_load_string($response->body());
        $rates = [];

        foreach ($xml->Body->Cube->Rate as $rate) {
            $currency = (string)$rate['currency'];
            $multiplier = (int)$rate['multiplier'];
            $value = (float)$rate;
            if ($multiplier > 1) {
                // If multiplier is greater than 1, adjust the rate accordingly
                $value = $value / $multiplier;
            }
            $rates[$currency] = $value;
        }

        return $rates;
    }
}
