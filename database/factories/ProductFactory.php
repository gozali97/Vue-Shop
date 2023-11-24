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
            'title' => $title = $this->faker->name(),
            'slug' => str($title)->slug(),
            'price' => rand(100, 1000),
            'quantity' => rand(1, 15),
            'category_id' => rand(1, 5),
            'brand_id' => rand(1, 6),
            'inStock' => 1,
            'published' => 1,
            'created_by' => 1,
            'description' => $this->faker->sentence(),
        ];
    }
}
