<?php

namespace Database\Factories\User;

use App\Models\User\User;
use App\Models\User\UserDetails;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserDetailsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = UserDetails::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->unique()->numberBetween(1, 10),
            'date_of_birth' => $this->faker->unique()->dateTimeBetween('-50 years', '-18 years'),
            'gender' => $this->faker->randomElement(['M', 'F']),
            'height' => mt_rand(100, 200),
            'weight' => mt_rand(30, 80),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): Factory
    {
        return $this->state(function (array $attributes) {
            return [];
        });
    }
}
