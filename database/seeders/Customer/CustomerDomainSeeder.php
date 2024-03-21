<?php

namespace Database\Seeders\Customer;

use Illuminate\Database\Seeder;
use Modules\Tenants\App\Models\Customer\CustomerDomain;

class CustomerDomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        CustomerDomain::factory()->count(10)->create();
    }
}
