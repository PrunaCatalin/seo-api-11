<?php

namespace Database\Seeders\Payment;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Tenants\App\Models\Payment\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        PaymentMethod::create([
            'name' => 'Stripe',
            'provider' => 'Stripe',
            'is_active' => 1,
            'is_sandbox' => 1,
            'country_id' => 250,
            'configurations' => [],
        ]);
    }
}
