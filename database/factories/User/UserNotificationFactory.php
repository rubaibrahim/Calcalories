<?php

namespace Database\Factories\User;

use App\Models\User\User;
use App\Models\User\UserDetails;
use App\Models\User\UserNotification;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserNotificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = UserNotification::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'type' => mt_rand(1, 2), // 1=notify, 2=action
            'title' => $this->faker->realText(mt_rand(20, 50)),
            'message' => $this->faker->realText(mt_rand(100, 300)),
            'ids' => '[' . mt_rand(1, 3) .']', // [] : 1=protein , 2=iron , 3=a
            'is_read' => mt_rand(0, 1), // 1=Yes, 0=No
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
