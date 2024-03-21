<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Tenants\App\Models\Customer\Customer;
use Modules\Tenants\App\Models\Customer\CustomerAddress;
use Modules\Tenants\App\Models\Location\GenericCity;

/**
 * @extends Factory<Model>
 */
class CustomerAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = CustomerAddress::class;

    public function definition()
    {
        $randomCity = GenericCity::inRandomOrder()->first();
        return [
            'customer_id' => Customer::factory(),
            'city_id' => $randomCity->id, // Presupunând că ai un set de ID-uri valide pentru orașe
            'county_id' => $randomCity->county_id, // Similar pentru județe
            'person_name' => fake()->firstName,
            'person_lastname' => fake()->lastName,
            'person_phone' => fake()->phoneNumber,
            'person_email' => fake()->safeEmail,
            'person_street_name' => fake()->streetName,
            'person_street_number' => fake()->buildingNumber,
            'person_zip_code' => fake()->postcode,
            'person_additional_info' => fake()->sentence,
        ];
    }
}
