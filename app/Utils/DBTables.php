<?php

namespace App\Utils;

class DBTables
{
    // Meal
    const MEAL_TYPES = "male_types";
    const MEAL_RECIPES = "male_recipes";

    // User
    const USERS = "users";
    const USER_DETAILS = "user_details";
    const USER_SUPPORTS = "user_supports";

    // Plan
    const USER_PLANS = "user_plans";
    const USER_PLAN_MEALS = "user_plan_meals";

    const USER_NOTIFICATIONS = "user_notifications";


    // important command

    // to create project
    // - composer create-project laravel/laravel CoronaAPI

    // to create database
    // - php artisan migrate
    // - php artisan migrate:rollback

    // to create dummy data
    // - php artisan make:seeder DatabaseSeeder // Create seed file
    // - php artisan db:seed // Run seed
    // - php artisan db:wipe // Dropped all tables

    // to run project
    // - php artisan serve
}
