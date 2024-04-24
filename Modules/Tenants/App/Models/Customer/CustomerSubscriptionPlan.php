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
    protected $fillable = ['is_active', 'frequency', 'ended_at', 'status'];
    protected $hidden = ['customer_id'];
    protected $casts = [
        'ended_at' => 'datetime'
    ];

}
