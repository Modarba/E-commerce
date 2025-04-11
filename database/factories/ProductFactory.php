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
                'name' => $this->faker->word(),
            'category_id'=> $this->faker->numberBetween(1,5),
                'description' => $this->faker->sentence(),
                'price' => $this->faker->numberBetween(100, 500),
                'quantity' => $this->faker->numberBetween(1, 20),
                'image' => 'products/default.png',
        ];
    }
}
