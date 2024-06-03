<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Tenants\App\Models\Customer\CustomerDomainSettings;
use Modules\Tenants\App\Models\Location\GenericCountry;

class CustomerDomainSettingsFactory extends Factory
{
    protected $model = CustomerDomainSettings::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $words = [];
        for ($i = 0; $i < 10; $i++) {
            $words[] = fake()->word;
        }
        $paths = [];
        for ($i = 0; $i < 1000; $i++) {
            $type = fake()->randomElement(['products', 'category/product', 'tags']);
            $item = fake()->word;
            $paths[] = "{$type}/{$item}";
        }
        return [
            //
            'customer_id' => 1,
            'customer_domains_id' => 1,
            'countries' => GenericCountry::inRandomOrder()->limit(10)->pluck('id'),
            'keywords' => $words,
            'links' => $paths
        ];
    }
}
