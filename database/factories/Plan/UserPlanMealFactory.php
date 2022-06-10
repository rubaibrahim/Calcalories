<?php

namespace Database\Factories\Plan;

use App\Models\Plan\UserPlanMeal;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserPlanMealFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = UserPlanMeal::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_plan_id' => $this->faker->unique()->biasedNumberBetween(1, 40),
            'name' => $this->faker->realText(mt_rand(20, 100)),
            'calories' =>  mt_rand(10, 500),
            'vitamin_protein' =>  mt_rand(10, 50),
            'vitamin_iron' =>  mt_rand(5, 20),
            'vitamin_a' =>  mt_rand(50, 500),
            'updated_at' => $this->faker->unique()->dateTimeBetween('-50 days', '-5 days'),
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
