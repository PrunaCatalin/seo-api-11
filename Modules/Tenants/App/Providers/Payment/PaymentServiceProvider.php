<?php
/*
 * seo-api | PaymentServiceProvider.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 4/18/2024 3:39 PM
*/

namespace Modules\Tenants\App\Providers\Payment;

use Exception;
use Illuminate\Support\ServiceProvider;
use Modules\Tenants\App\Contracts\PaymentGateway;
use Modules\Tenants\App\Services\Payment\PaypalPaymentGateway;
use Modules\Tenants\App\Services\Payment\StripePaymentGateway;

class PaymentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(PaymentGateway::class, function ($app) {
            switch (config('services.payment_gateway.active')) {
                case 'stripe':
                    return new StripePaymentGateway();
                case 'paypal':
                    return new PayPalPaymentGateway();
                default:
                    throw new Exception('Unsupported payment gateway');
            }
        });
    }
}
