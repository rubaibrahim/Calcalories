<?php

namespace Database\Factories\Meal;

use App\Models\Meal\MealRecipe;
use Illuminate\Database\Eloquent\Factories\Factory;

class MealRecipeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = MealRecipe::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'meal_type_id' =>  mt_rand(1, 4),
            'name' => $this->faker->realText(mt_rand(20, 100)),
            'details' => $this->faker->realText(mt_rand(100, 1000)),
            'img_url' => $this->faker->imageUrl(200,200),
            'calories' =>  mt_rand(500, 2000),
            'vitamin_protein' =>  mt_rand(10, 100),
            'vitamin_iron' =>  mt_rand(10, 25),
            'vitamin_a' =>  mt_rand(500, 1000),
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
