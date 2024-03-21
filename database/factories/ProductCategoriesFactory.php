<?php
/*
 * ${PROJECT_NAME} | ProductCategoriesFactory.php
 * https://www.webdirect.ro/
 * Copyright 2023 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 12:24
*/

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Modules\Tenants\App\Models\Category\Category;

class ProductCategoriesFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'id_parent' => fake()->randomNumber(),
            'id_image' => fake()->randomNumber(),
            'order_list' => fake()->randomNumber(),
            'name' => fake()->name(),
            'url_seo' => fake()->url(),
            'icon' => fake()->word(),
            'is_customer' => fake()->boolean(),
            'age_restricted' => fake()->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
