<?php
/*
 * ${PROJECT_NAME} | PaymentController.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 18.04.2024 13:57
*/

namespace Modules\Tenants\App\Http\Controllers\PaymentController;

use App\Http\Controllers\Controller;
use App\Services\Payment\StripeService;

use Exception;
use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Log;
use Modules\Tenants\App\Exceptions\ServiceException;
use Modules\Tenants\App\Http\Requests\Payment\CheckoutRequest;
use Modules\Tenants\App\Models\Subscription\SubscriptionPlan;
use Modules\Tenants\App\Models\Tenant\Domains;
use Modules\Tenants\App\Services\Customer\CustomerService;
use Stripe\Exception\ApiErrorException;

class PaymentController extends Controller
{
    public function __construct(
        private readonly StripeService $stripeService,
        private readonly CustomerService $customerService,
    ) {
    }

    /**
     * @throws ApiErrorException
     * @throws Exception
     */
    public function checkout(CheckoutRequest $checkoutRequest)
    {
        if ($checkoutRequest->validated()) {
            $checkoutPlan = SubscriptionPlan::find($checkoutRequest->planId);
            $stripePlans = $this->stripeService->getAllProducts();

            if (isset($stripePlans->data) && $checkoutPlan) {
                try {
                    $customer = $this->customerService->find(id: auth('customer')->user()->id);
                    $domain = Domains::firstWhere('tenant_id', $customer->tenant_id);
                    foreach ($stripePlans->data as $data) {
                        if (
                            $checkoutPlan->name == $data->product->name &&
                            $checkoutRequest->frequency == $data->recurring->interval
                        ) {
                            $checkout = $customer->newSubscription($data->product->id, $data->id)
                                ->checkout([
                                    'success_url' => 'http://' . $domain->domain . '/v1/payment/success',
                                    'cancel_url' => 'http://' . $domain->domain . '/v1/payment/failed',
                                ]);

                            return response()->json(data: [
                                'status' => 'success',
                                'response' => $checkout
                            ]);
                        }
                    }
                } catch (ServiceException $e) {
                    return response()->json(data: [
                        'status' => false,
                        'errors' => $e->getMessage()
                    ]);
                }
            } else {
                return response()->json(data: [
                    'status' => false,
                    'errors' => 'Plan not found'
                ]);
            }
        } else {
            return response()->json(data: [
                'status' => false,
                'errors' => 'Plan not found'
            ]);
        }
    }
}
