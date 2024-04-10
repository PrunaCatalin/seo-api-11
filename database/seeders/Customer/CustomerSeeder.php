<?php

namespace Database\Seeders\Customer;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Tenants\App\Models\Customer\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $test = [
            'email' => 'prunacatalin.costin@gmail.com',
            'email_verified_at' => fake()->dateTime(),
            'password' => bcrypt('password'),
            'tenant_id' => 'seofronttest',
            'referral_id' => (string)Str::uuid(),
            'remember_token' => Str::random(10),
        ];
        Customer::create($test);
        Customer::factory()->count(10)->create();
    }
}
