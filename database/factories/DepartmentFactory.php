<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? 1,
            'headDescription' => $this->faker->sentence(6),
            'description' => $this->faker->sentence(6),
            'area' => $this->faker->numberBetween(70, 200),
            'location' => [
                'governorate' => $this->faker->randomElement(['Damascus', 'Aleppo', 'Homs', 'Latakia']),
                'city' => $this->faker->city,
                'district' => $this->faker->word,
                'street' => $this->faker->streetName,
            ],
            'bedrooms' => $this->faker->numberBetween(1, 5),
            'bathrooms' => $this->faker->numberBetween(1, 3),
            'floor' => $this->faker->numberBetween(0, 20),
            'rentFee' => $this->faker->randomFloat(2, 10, 100),
            'isAvailable' => $this->faker->boolean,
            'status' => $this->faker->randomElement(['furnished', 'unfurnished', 'partially furnished']),
        ];
    }
}
