<?php

namespace Database\Seeders\Customer;

use Illuminate\Database\Seeder;
use Modules\Tenants\App\Models\Customer\CustomerAddress;

class CustomerAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        CustomerAddress::factory()->count(10)->create();
    }
}
