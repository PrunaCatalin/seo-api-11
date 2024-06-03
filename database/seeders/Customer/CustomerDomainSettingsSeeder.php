<?php

namespace Database\Seeders\Customer;

use Illuminate\Database\Seeder;
use Modules\Tenants\App\Models\Customer\CustomerDomainSettings;

class CustomerDomainSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
       CustomerDomainSettings::factory()->create();
    }
}
