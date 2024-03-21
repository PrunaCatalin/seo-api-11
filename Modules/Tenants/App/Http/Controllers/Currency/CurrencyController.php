<?php

/*
 * ${PROJECT_NAME} | CurrencyConvertorController.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 02.02.2024 11:56
*/

namespace Modules\Tenants\App\Http\Controllers\Currency;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Tenants\App\Factories\ExchangeRateServiceFactory;
use Modules\Tenants\App\Http\Requests\Currency\ConvertCurrencyRequest;
use Modules\Tenants\App\Exceptions\ServiceException;

class CurrencyController extends Controller
{
    protected ExchangeRateServiceFactory $currencyConverter;

    public function __construct(ExchangeRateServiceFactory $currencyConverter)
    {
        $this->currencyConverter = $currencyConverter;
    }

    /**
     * Handle the incoming request.
     *
     * @param ConvertCurrencyRequest $request
     * @return JsonResponse
     * @throws ServiceException
     */
    public function __invoke(ConvertCurrencyRequest $request)
    {
        $convertedAmount = $this->currencyConverter::create(
            $request->service ?? config('tenants.convert.service')
        )->convertToRon($request->amount, $request->currency);

        if ($convertedAmount === null) {
            return response()->json(['error' => 'Unsupported currency or invalid amount.'], 422);
        }

        return response()->json([
            'amount' => $request->amount,
            'currency' => $request->currency,
            'converted_amount' => $convertedAmount,
            'converted_currency' => 'RON',
        ]);
    }
}
