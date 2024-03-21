<?php

namespace Database\Seeders\Customer;

use Illuminate\Database\Seeder;
use Modules\Tenants\App\Models\Customer\CustomerDetails;

class CustomerDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        CustomerDetails::factory()->count(10)->create();
    }
}
