<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Tenants\App\Models\Customer\Customer;

/**
 * @extends Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail,
            'email_verified_at' => fake()->dateTime(),
            'password' => bcrypt('password'),
            'tenant_id' => 'seofronttest',
            'referral_id' => (string)Str::uuid(),
            'remember_token' => Str::random(10),
        ];
    }
}
