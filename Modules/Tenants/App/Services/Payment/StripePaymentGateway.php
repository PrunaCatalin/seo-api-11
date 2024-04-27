<?php
/*
 * seo-api | StripePaymentGateway.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 4/18/2024 3:40 PM
*/

namespace Modules\Tenants\App\Services\Payment;

use App\Services\Payment\StripeService;
use Exception;
use Illuminate\Support\Facades\Log;
use Modules\Tenants\App\Contracts\PaymentProvider;
use Modules\Tenants\App\Exceptions\ServiceException;
use Modules\Tenants\App\Models\Customer\Customer;
use Modules\Tenants\App\Models\Subscription\SubscriptionPlan;
use Modules\Tenants\App\Models\Tenant\Domains;

class StripePaymentGateway implements PaymentProvider
{
    public function __construct(private readonly StripeService $stripeService)
    {
    }

    public function charge($amount)
    {
        // TODO
    }

    public function refund($transactionId)
    {
        // TODO
    }

    public function processPayment($requestData, Customer $customer, SubscriptionPlan $subscriptionPlan)
    {
        try {
            $stripePlans = $this->stripeService->getAllProducts();
            $domain = Domains::firstWhere('tenant_id', $customer->tenant_id);

            if (isset($stripePlans->data)) {
                foreach ($stripePlans->data as $data) {
                    if (isset($data->recurring) && $data->recurring !== null) {
                        $parseFrequency = match ($data->recurring->interval) {
                            'month' => 'monthly',
                            'year' => 'yearly',
                            default => null
                        };
                    } else {
                        $parseFrequency = 'onetime';
                    }
                    if ($subscriptionPlan->name == $data->product->name && $subscriptionPlan->frequency == $parseFrequency) {
                        $subscription = $customer->newSubscription($data->product->id, $data->id)
                            ->checkout([
                                'success_url' => 'http://' . $domain->domain . '/v1/payment/success',
                                'cancel_url' => 'http://' . $domain->domain . '/v1/payment/failed',
                            ]);

                        return [
                            'status' => 'success',
                            'payment' => $subscription
                        ];
                    }
                }
            }
            return ['status' => 'error', 'message' => 'Suitable Stripe plan not found'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

}
