<?php

namespace Database\Seeders;

use Database\Seeders\App\AppConfigSeeder;
use Database\Seeders\Currency\CurrencySeeder;
use Database\Seeders\Customer\CustomerAddressSeeder;
use Database\Seeders\Customer\CustomerCompanySeeder;
use Database\Seeders\Customer\CustomerDetailsSeeder;
use Database\Seeders\Customer\CustomerDomainSeeder;
use Database\Seeders\Customer\CustomerSeeder;
use Database\Seeders\Location\GenericCitiesSeeder;
use Database\Seeders\Location\GenericCountiesSeeder;
use Database\Seeders\Location\GenericCountriesSeeder;
use Database\Seeders\Tenant\TenantConfigurationSeeder;
use Database\Seeders\Tenant\TenantSeeder;
use Database\Seeders\User\UserPermissionSeeder;
use Database\Seeders\User\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $this->call(TenantSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
//        $this->call(WdApplicationLinksSeeder::class);
        $this->call(TenantConfigurationSeeder::class);
        $this->call(AppConfigSeeder::class);

        $this->call(UserSeeder::class);

        $this->call(CurrencySeeder::class);
        $this->call([
            GenericCountriesSeeder::class,
            GenericCountiesSeeder::class,
            GenericCitiesSeeder::class,
        ]);
        $this->call(UserPermissionSeeder::class);
        //Customer
        $this->call([
            CustomerSeeder::class,
            CustomerAddressSeeder::class,
            CustomerCompanySeeder::class,
            CustomerDetailsSeeder::class,
            CustomerDomainSeeder::class,
        ]);
    }
}
