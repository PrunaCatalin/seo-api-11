<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Tenants\App\Models\Customer\Customer;
use Modules\Tenants\App\Models\Customer\CustomerCompany;
use Modules\Tenants\App\Models\Location\GenericCity;

/**
 * @extends Factory<Model>
 */
class CustomerCompanyFactory extends Factory
{
    protected $model = CustomerCompany::class;

    public function definition()
    {
        $randomCity = GenericCity::inRandomOrder()->first();
        return [
            'customer_id' => Customer::factory(),
            'city_id' => $randomCity->id,
            'county_id' => $randomCity->county_id,
            'company_name' => fake()->company,
            'prefix_code' => fake()->bothify('???###'),
            'cui_code' => fake()->randomNumber(8),
            'commerce_reg_letter' => fake()->bothify('???'),
            'county_code' => fake()->bothify('##'),
            'company_year' => fake()->year,
            'bank_name' => 'Bank ' . fake()->word,
            'iban_account' => fake()->iban('RO'),
            'company_address' => fake()->address,
        ];
    }
}
