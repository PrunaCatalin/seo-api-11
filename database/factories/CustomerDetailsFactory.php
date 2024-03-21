<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Tenants\App\Models\Customer\Customer;
use Modules\Tenants\App\Models\Customer\CustomerDetails;

/**
 * @extends Factory<Model>
 */
class CustomerDetailsFactory extends Factory
{
    protected $model = CustomerDetails::class;

    public function definition()
    {
        return [
            'customer_id' => Customer::factory(),
            'name' => fake()->firstName,
            'lastname' => fake()->lastName,
            'date_of_birth' => fake()->date,
            'phone' => fake()->phoneNumber,
            'gender' => fake()->boolean,
        ];
    }
}
