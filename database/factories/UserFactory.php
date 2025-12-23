<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;
    public function definition(): array
    {
        return [
            'first_name' => fake('en_SA')->firstName(),
            'last_name'  => fake('en_SA')->lastName(),
            'phone' => fake()->numerify('09########'),
            'location' => [
                'governorate' => $this->faker->randomElement(['Damascus', 'Aleppo', 'Homs', 'Latakia']),
                'city' => $this->faker->city,
                'district' => $this->faker->word,
                'street' => $this->faker->streetName,
            ],
            'birthdate' => fake()->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
