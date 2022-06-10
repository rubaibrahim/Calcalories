<?php

namespace Database\Factories\User;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make("123456"), // $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
            'fcm_token' => Str::random(163), // d0wjYHZhS7qGleIana1Ga1:APA91bFyXcrP6j3Du4EFJCa33eCoEO-6LZPsvspqn3pzqJz7lO5sdmfyzsfNsG-H_AiVZ67IIUTNiLdOaN37Vrz3AyYE1HUOxR-ZHEDCOO0uv1isqNvy_Nf2DJtBupkzgf9byXV0nKSl
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
