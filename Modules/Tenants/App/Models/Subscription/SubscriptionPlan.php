<?php
/*
 * ${PROJECT_NAME} | SubscriptionPlan.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 27.03.2024 18:03
*/

namespace Modules\Tenants\App\Models\Subscription;

use Illuminate\Database\Eloquent\Model;
use Modules\Tenants\App\Models\Customer\Customer;
use Modules\Tenants\App\Models\Customer\CustomerSubscriptionPlan;

class SubscriptionPlan extends Model
{
    protected $fillable = ['name', 'points', 'frequency', 'description', 'details', 'is_popular', 'points_annually'];
    protected $hidden = ['rate', 'is_active'];

    /**
     * Get the details for the subscription plan.
     */
    public function details()
    {
        return $this->hasMany(SubscriptionPlanDetail::class);
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'customer_subscription_plan')
            ->using(CustomerSubscriptionPlan::class)
            ->withTimestamps();
    }

    public function scopeIsActive()
    {
        return $this->where('is_active', 1);
    }
}
