<?php

namespace Database\Seeders\Subscription;

use Illuminate\Database\Seeder;
use Modules\Tenants\App\Models\Subscription\SubscriptionPlan;

class SubscriptionPlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        SubscriptionPlan::insert([
            [
                'name' => 'Standard',
                'points' => 299.99,
                'points_annually' => 12 * 299.99,
                'frequency' => 'monthly',
                'description' => 'A Standard subscription plan',
                'rate' => 9.9997,
                'is_active' => 1,
                'is_popular' => 0,
            ],
            [
                'name' => 'Advanced',
                'points' => 799.99,
                'points_annually' => 12 * 799.99,
                'frequency' => 'monthly',
                'description' => 'A Advanced subscription plan',
                'rate' => 26.67,
                'is_active' => 1,
                'is_popular' => 1,
            ],
            [
                'name' => 'Executive',
                'points' => 1499.99,
                'points_annually' => 12 * 1499.99,
                'frequency' => 'monthly',
                'description' => 'A Executive subscription plan',
                'rate' => 50,
                'is_active' => 1,
                'is_popular' => 0,
            ],
        ]);
    }
}
