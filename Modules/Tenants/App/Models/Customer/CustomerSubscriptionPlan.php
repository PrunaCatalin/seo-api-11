<?php
/*
 * ${PROJECT_NAME} | CustomerSubscriptionPlan.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 27.03.2024 18:14
*/

namespace Modules\Tenants\App\Models\Customer;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Cache;
use Modules\Tenants\App\Services\Customer\WalletService;

class CustomerSubscriptionPlan extends Pivot
{
    // Define the table if it's not the default naming convention
    protected $table = 'customer_subscription_plan';
    protected $hidden = ['customer_id'];

    protected static function boot()
    {
        parent::boot();
        // Re-cache the new wallet data if necessary
        // Here you might want to repopulate the cache with fresh data
        // For example:
        static::saved(function ($customerPlan) {
            $cacheKey = 'wallet_data_for_user_' . $customerPlan->customer_id;
            Cache::forget($cacheKey);
            $newWalletData = (new WalletService())->getWallet($customerPlan->customer_id);
            Cache::put($cacheKey, $newWalletData, 3600);
        });
        static::created(function ($customerPlan) {
            $cacheKey = 'wallet_data_for_user_' . $customerPlan->customer_id;
            $newWalletData = (new WalletService())->getWallet($customerPlan->customer_id);
            Cache::put($cacheKey, $newWalletData, 3600);
        });
    }
}
