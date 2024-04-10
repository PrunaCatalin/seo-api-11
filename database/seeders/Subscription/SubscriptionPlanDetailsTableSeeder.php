<?php

namespace Database\Seeders\Subscription;

use Illuminate\Database\Seeder;
use Modules\Tenants\App\Models\Subscription\SubscriptionPlanDetail;

class SubscriptionPlanDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $details = [
            ['subscription_plan_id' => 1, 'key' => 'daily_traffic', 'value' => '10.000', 'name' => 'Daily Traffic'],
            ['subscription_plan_id' => 1, 'key' => 'domains', 'value' => '1', 'name' => 'Domains'],
            [
                'subscription_plan_id' => 1,
                'key' => 'monthly_traffic',
                'value' => 'Max 300.000',
                'name' => 'Monthly Traffic'
            ],
            ['subscription_plan_id' => 1, 'key' => 'keyword_list', 'value' => 'Yes', 'name' => 'Keyword List'],
            [
                'subscription_plan_id' => 1,
                'key' => 'google_domain_selection',
                'value' => 'Yes',
                'name' => 'Google domain selection'
            ],

            ['subscription_plan_id' => 2, 'key' => 'daily_traffic', 'value' => '50,000', 'name' => 'Daily Traffic'],
            ['subscription_plan_id' => 2, 'key' => 'domains', 'value' => '1-3', 'name' => 'Domains'],
            [
                'subscription_plan_id' => 2,
                'key' => 'monthly_traffic',
                'value' => 'Max 1.500.000',
                'name' => 'Monthly Traffic'
            ],
            ['subscription_plan_id' => 2, 'key' => 'keyword_list', 'value' => 'Yes', 'name' => 'Keyword List'],
            [
                'subscription_plan_id' => 2,
                'key' => 'google_domain_selection',
                'value' => 'Yes',
                'name' => 'Google domain selection'
            ],

            ['subscription_plan_id' => 3, 'key' => 'daily_traffic', 'value' => '250,000', 'name' => 'Daily Traffic'],
            ['subscription_plan_id' => 3, 'key' => 'domains', 'value' => '1-10', 'name' => 'Domains'],
            [
                'subscription_plan_id' => 3,
                'key' => 'monthly_traffic',
                'value' => 'Max 7.500.000',
                'name' => 'Monthly Traffic'
            ],
            ['subscription_plan_id' => 3, 'key' => 'keyword_list', 'value' => 'Yes', 'name' => 'Keyword List'],
            [
                'subscription_plan_id' => 3,
                'key' => 'google_domain_selection',
                'value' => 'Yes',
                'name' => 'Google domain selection'
            ]
        ];
        SubscriptionPlanDetail::insert($details);
    }
}
