<?php

namespace Database\Seeders\Customer;

use Illuminate\Database\Seeder;
use Modules\Tenants\App\Models\Customer\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Customer::factory()->count(10)->create();
    }
}
