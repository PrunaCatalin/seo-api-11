<?php
/*
 * ${PROJECT_NAME} | SubscriptionPlanDetail.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 27.03.2024 18:04
*/

namespace Modules\Tenants\App\Models\Subscription;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlanDetail extends Model
{
    protected $fillable = ['subscription_plan_id', 'name', 'key', 'value'];
    protected $hidden = ['subscription_plan_id'];

    /**
     * Get the subscription plan that owns the detail.
     */
    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }
}
