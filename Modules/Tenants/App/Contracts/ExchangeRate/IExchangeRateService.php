<?php

/*
 * wdirect-api | ExchangeRateService.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : Javascript
 * Created on : 2/2/2024 12:30 PM
*/

namespace Modules\Tenants\Contracts\ExchangeRate;

interface IExchangeRateService
{
    public function convertToRon(float $amount, string $currency);
}
