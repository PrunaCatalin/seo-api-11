<?php
/*
 * seo-api | PaymentProviderFactory.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 4/27/2024 11:43 AM
*/

namespace Modules\Tenants\App\Factories;

use App\Services\Payment\StripeService;
use Exception;
use Modules\Tenants\App\Exceptions\ServiceException;
use Modules\Tenants\App\Models\Payment\PaymentMethod;
use Modules\Tenants\App\Services\Payment\PaypalPaymentGateway;
use Modules\Tenants\App\Services\Payment\StripePaymentGateway;

class PaymentProviderFactory
{
    /**
     * @param $paymentMethodId
     * @return mixed
     * @throws ServiceException
     */
    public static function getPaymentProvider($paymentMethodId)
    {
        $paymentMethod = PaymentMethod::find($paymentMethodId);

        if (!$paymentMethod) {
            throw new ServiceException('Payment method not found');
        }

        $provider = $paymentMethod->provider;

        return match ($provider) {
            'Stripe' => app(StripePaymentGateway::class),
            'PayPal' => app(PaypalPaymentGateway::class),
            default => throw new ServiceException('Unsupported payment provider: ' . $provider),
        };
    }
}
