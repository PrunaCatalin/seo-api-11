<?php

namespace Database\Seeders\Customer;

use Illuminate\Database\Seeder;
use Modules\Tenants\App\Models\Customer\CustomerSubscriptionPlan;

class CustomerSubscriptionPlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $plans = [
            ['customer_id' => 1, 'subscription_plan_id' => 1],
            ['customer_id' => 2, 'subscription_plan_id' => 2]
        ];
        CustomerSubscriptionPlan::insert($plans);
    }
}
