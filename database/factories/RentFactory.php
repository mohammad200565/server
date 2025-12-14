<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'department_id' => Department::inRandomOrder()->first()->id,
            'startRent' => fake()->dateTimeBetween('now', '+3 month'),
            'endRent' => fake()->dateTimeBetween('+3 month', '+12 month'),
            'status' => fake()->randomElement(['cancelled', 'pending', 'completed', 'onRent']),
            'rentFee' => fake()->randomFloat(2, 300, 2000),
        ];
    }
}
