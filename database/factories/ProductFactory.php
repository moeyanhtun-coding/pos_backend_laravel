<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'productCode' => "P".mt_rand(3000, 999999),
            'productName' => fake()->name(),
            'price' => rand(500,100000),
            'ProductCategoryId' => rand(1,10)
        ];
    }
}
