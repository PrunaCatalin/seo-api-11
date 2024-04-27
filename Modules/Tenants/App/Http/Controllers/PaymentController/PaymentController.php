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

use Exception;
use Modules\Tenants\App\Exceptions\ServiceException;
use Modules\Tenants\App\Factories\PaymentProviderFactory;
use Modules\Tenants\App\Http\Requests\Payment\CheckoutRequest;
use Modules\Tenants\App\Models\Subscription\SubscriptionPlan;
use Stripe\Exception\ApiErrorException;

class PaymentController extends Controller
{
    public function __construct()
    {
    }

    /**
     * @throws ApiErrorException
     * @throws Exception
     */
    public function checkout(CheckoutRequest $checkoutRequest)
    {
        if (!$checkoutRequest->validated()) {
            return $this->respondWithError('Validation failed.');
        }

        try {
            $checkoutPlan = SubscriptionPlan::find($checkoutRequest->planId);
            if (!$checkoutPlan) {
                return $this->respondWithError('Plan not found');
            }

            $checkoutMethod = PaymentProviderFactory::getPaymentProvider($checkoutRequest->paymentMethodId);
            $response = $checkoutMethod->processPayment(
                $checkoutRequest->data,
                auth('customer')->user(),
                $checkoutPlan
            );

            return $this->handlePaymentResponse($response);
        } catch (ServiceException $e) {
            return $this->respondWithError($e->getMessage());
        }
    }

    private function handlePaymentResponse($response)
    {
        if ($response['status'] === 'success') {
            return response()->json([
                'status' => 'success',
                'response' => $response['payment']
            ]);
        }

        return $this->respondWithError($response['message']);
    }

    private function respondWithError($message)
    {
        return response()->json([
            'status' => false,
            'errors' => $message
        ]);
    }
}
