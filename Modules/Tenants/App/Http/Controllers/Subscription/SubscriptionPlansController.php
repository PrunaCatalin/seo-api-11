<?php
/*
 * ${PROJECT_NAME} | SubscriptionPlansController.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 29.03.2024 12:28
*/

namespace Modules\Tenants\App\Http\Controllers\Subscription;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Modules\Tenants\App\Models\Payment\PaymentMethod;
use Modules\Tenants\App\Models\Subscription\SubscriptionPlan;

class SubscriptionPlansController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        $cacheKey = 'subscription_plans';

        // Attempt to retrieve the wallet data from the cache

        $customer = auth('sanctum')->user()->id;
        $plans = SubscriptionPlan::isActive()->hasNeverBeenDemoForCustomer($customer)->with('details')->get();
        $paymentMethods = PaymentMethod::isActive()->get()->map(function ($paymentMethod) {
            return [
                'label' => $paymentMethod->name,
                // Schimbă 'name' cu numele coloanei din baza de date pe care vrei să-l folosești pentru etichetă
                'value' => $paymentMethod->id,
                // Schimbă 'id' cu numele coloanei din baza de date pe care vrei să-l folosești pentru valoare
            ];
        })->toArray();

        return response()->json([
            'status' => 'success',
            'response' => $plans,
            'payment_methods' => $paymentMethods
        ]);
    }


}
