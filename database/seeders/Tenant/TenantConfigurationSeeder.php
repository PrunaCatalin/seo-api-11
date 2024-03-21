<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use Modules\Tenants\App\Models\Tenant\TenantConfiguration;

class TenantConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Used like this because model will encrypt default values
        $import = new TenantConfiguration();
        $import->domain_id = 1;
        $import->endpoint = env("APP_HOSTNAME");
        $import->username = "test_username";
        $import->password = "test_password";
        $import->secret = "test_secret";
        $import->tenant_type = "demo";
        $import->save();
    }
}
