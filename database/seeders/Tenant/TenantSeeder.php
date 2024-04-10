<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Tenant;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $primaryDomain = config('app.appHostNameTenant');
        
        $tenant = Tenant::firstOrCreate(['id' => Str::slug($primaryDomain, '')]);
        $tenant->domains()->create(['domain' => $primaryDomain, 'is_active' => 1]);

        $primaryDomain = config('app.appHostNameTenantTest');
        $tenant = Tenant::firstOrCreate(['id' => Str::slug($primaryDomain, '')]);
        $tenant->domains()->create(['domain' => $primaryDomain, 'is_active' => 1]);
    }
}
