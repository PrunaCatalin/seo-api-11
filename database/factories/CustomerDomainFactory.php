<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Tenants\App\Models\Customer\Customer;
use Modules\Tenants\App\Models\Customer\CustomerDomain;

/**
 * @extends Factory<Model>
 */
class CustomerDomainFactory extends Factory
{
    protected $model = CustomerDomain::class;

    public function definition()
    {
        return [
            'customer_id' => Customer::factory(),
            'domain' => time() . fake()->domainName,
            'tenant_id' => 'seofronttest',
        ];
    }
}
