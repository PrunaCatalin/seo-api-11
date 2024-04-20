<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Tenants\App\Models\Subscription\SubscriptionPlan as TenantSubscriptionPlan;

class SubscriptionPlan extends TenantSubscriptionPlan
{
    use HasFactory;

    protected $hidden = [];
}
