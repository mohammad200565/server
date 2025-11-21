<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1, 1),
            'description' => fake()->sentence(6),
            'size' => fake()->randomFloat(2, 30, 200),
            'location' => fake()->city,
            'rentFee' => fake()->randomFloat(2, 100, 2000),
            'isAvailable' => fake()->boolean,
            'status' => fake()->randomElement(['furnished', 'unfurnished', 'partially furnished']),
        ];
    }
}
