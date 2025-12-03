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
                'country' => 'Syria',
                'governorate' => $this->faker->randomElement(['Damascus', 'Aleppo', 'Homs', 'Latakia']),
                'city' => $this->faker->city,
                'district' => $this->faker->word,
                'street' => $this->faker->streetName,
            ],
            'bedrooms' => $this->faker->numberBetween(1, 5),
            'bathrooms' => $this->faker->numberBetween(1, 3),
            'floor' => $this->faker->numberBetween(0, 20),
            'favoritesCount' => 0,
            'rentFee' => $this->faker->randomFloat(2, 100, 2000),
            'isAvailable' => $this->faker->boolean,
            'status' => $this->faker->randomElement(['furnished', 'unfurnished', 'partially furnished']),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Department $department) {
            $imageCount = $this->faker->numberBetween(1, 5);
            for ($i = 0; $i < $imageCount; $i++) {
                $department->images()->create([
                    'path' => 'departments/fake_image_' . $this->faker->unique()->numberBetween(1, 1000) . '.jpg',
                ]);
            }
        });
    }
}
