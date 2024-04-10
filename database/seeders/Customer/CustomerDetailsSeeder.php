<?php

namespace Database\Seeders\Customer;

use Illuminate\Database\Seeder;
use Modules\Tenants\App\Models\Customer\Customer;
use Modules\Tenants\App\Models\Customer\CustomerDetails;

class CustomerDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        CustomerDetails::create(
            [
                'customer_id' => 1,
                'name' => fake()->firstName,
                'lastname' => fake()->lastName,
                'date_of_birth' => fake()->date,
                'phone' => fake()->phoneNumber,
                'gender' => fake()->boolean,
            ]
        );
        CustomerDetails::factory()->count(10)->create();
    }
}
