<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Tenants\App\Models\Customer\Customer;
use Modules\Tenants\App\Models\Customer\CustomerCompany;
use Modules\Tenants\App\Models\Location\GenericCity;
use Modules\Tenants\App\Models\Location\GenericCountry;

/**
 * @extends Factory<Model>
 */
class CustomerCompanyFactory extends Factory
{
    protected $model = CustomerCompany::class;

    public function definition()
    {
        $randomCountry = GenericCountry::inRandomOrder()->first();
        return [
            'customer_id' => Customer::factory(),
            'country_id' => $randomCountry->id,
            'company_name' => fake()->company,
            'identifier' => fake()->randomNumber(8),
            'swift' => fake()->swiftBicNumber(),
            'bank_name' => 'Bank ' . fake()->word,
            'iban_account' => fake()->iban($randomCountry->country_code),
            'company_address' => fake()->address,
        ];
    }
}
