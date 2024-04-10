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
        $plans = Cache::remember($cacheKey, 3600, function () {
            return SubscriptionPlan::isActive()->with('details')->get();
        });
        return response()->json([
            'status' => 'success',
            'response' => $plans
        ]);
    }


}
