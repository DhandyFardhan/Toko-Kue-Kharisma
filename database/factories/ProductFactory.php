<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word() . ' Cake',
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(30000, 150000),
            'stock' => $this->faker->numberBetween(1, 100),
            'image' => 'products/default.jpg',
        ];
    }
}
