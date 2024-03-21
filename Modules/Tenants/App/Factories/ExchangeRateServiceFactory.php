<?php

/*
 * wdirect-api | ExchangeRateServiceFactory.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email: office@webdirect.ro
 * Type: PHP
 * Created on: 2/2/2024 12:51 PM
 */

namespace Modules\Tenants\App\Factories;

use InvalidArgumentException;
use Modules\Tenants\Contracts\ExchangeRate\IExchangeRateService;
use Modules\Tenants\App\Exceptions\ServiceException;
use Modules\Tenants\Services\ExchangeService\BNRExchangeRateService;
use Modules\Tenants\Services\ExchangeService\InfoValutarExchangeRateService;

/**
 * Factory class for creating exchange rate service instances.
 * This factory allows for dynamic creation of exchange rate services
 * based on a specified type. Currently, it supports BNR (National Bank of Romania)
 * exchange rate service, with the capability to add more services as needed.
 */
class ExchangeRateServiceFactory
{
    /**
     * Creates an instance of an exchange rate service based on the specified type.
     *
     * @param string $serviceType The type of exchange rate service to create.
     * @return BnrExchangeRateService The instantiated exchange rate service.
     * @throws InvalidArgumentException If the specified service type is not supported.
     * @throws ServiceException
     */
    public static function create(string $serviceType): IExchangeRateService
    {
        return match ($serviceType) {
            'bnr' => new BnrExchangeRateService(),
            'infovalutar' => new InfoValutarExchangeRateService(),
            // Add new services here as case statements.
            default => throw new ServiceException(
                "The exchange rate service '$serviceType' is not supported."
            ),
        };
    }
}
