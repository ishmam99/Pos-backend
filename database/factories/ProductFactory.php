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
    public function definition()
    {
        return [
            'sku' => fake()->unique()->regexify('[A-Z]{3}-[0-9]{5}'),
            'slug' => fake()->slug(),
            'name' => fake()->word(),
            'image'=> 'https://png.pngtree.com/png-vector/20201123/ourmid/pngtree-isolated-parcel-box-vector-icon-png-image_2463878.jpg',
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(1, 100, 2),
            'stock' => fake()->numberBetween(0, 100),
            'is_active' => fake()->boolean(),
        ];
    }
}
