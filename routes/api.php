<?php

use Illuminate\Support\Facades\Route;


// =============================== Start App API ===============================
Route::group([
    'prefix' => 'app',
    'namespace' => 'App\Http\Controllers\API',
    //'middleware' => ['auth:sanctum']
], function () {

    // User Auth
    Route::post('register', 'User\AuthController@register');
    Route::post('login', 'User\AuthController@login');

    Route::middleware('auth:sanctum')->post('logout', 'User\AuthController@logout');

    Route::put('userDetails', 'User\UserController@updateDetails');

    Route::get('test22', 'User\AuthController@test2');

    Route::apiResources([
        // User
        'user' => 'User\UserController',
        'userNotification' => 'User\UserNotificationController',

        // Meal
        'mealType' => 'Meal\MealTypeController',
        'mealRecipe' => 'Meal\MealRecipeController',

        // Plan
        'userPlan' => 'Plan\UserPlanController',
        'userPlanMeal' => 'Plan\UserPlanMealController',

        'test' => 'Test\TestController',
    ]);

//    Route::get("getTest",'Test\TestController@index');
//    Route::get("getTest/{id}",'Test\TestController@show');
//    Route::post("getTest",'Test\TestController@store');
//    Route::put("getTest/{id}",'Test\TestController@update');
//    Route::delete("getTest/{id}",'Test\TestController@destroy');
});
// =============================== End App API =================================
