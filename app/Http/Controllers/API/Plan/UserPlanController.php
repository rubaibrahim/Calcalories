<?php

namespace App\Http\Controllers\API\Plan;

use App\Http\Controllers\Base\ApiController;
use App\Models\Meal\MealType;
use App\Models\Plan\UserPlan;
use App\Models\User\UserDetails;
use App\Utils\Utils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserPlanController extends ApiController
{
    const singleResultName = "user_plan";
    const multipleResultName = "user_plans";

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
 // after 24 hours day by day,, getalluserplans by current day
    public function index(Request $request): JsonResponse
    {
        // Check is user logged in
        if ($request->user()) {
            $user_id = $request->user()->id;

            // SELECT * FROM `user_plans` where user_id = $user_id
            $records = UserPlan::select("*")->where("user_id", "=", $user_id);

            $records->with([
                // select * from meal_Types where id  = $meal_type_id
                "mealType",
                // select id, mame ,email from user where id = $user_id
                "user" => function ($query) {
                    $query->select('id', 'name', "email");
                },
                // select * from user_plan_meals where user_plan_id = $id and updated_at = &date
                "meals" => function ($query)  use ($request) {
                    if ($field = self::requestHas($request, 'updated_at')) {
                        // where updated_at = $field
                        $query->whereDate('updated_at', $field);
                    }
                },
            ]);



            // Where
            if (($field = self::requestHas($request, 'mael_type_id')) != null) {
                // where mael_type_id = $field
                $records->where('mael_type_id', "=", $field);
            }

            // Sort
            // ORDER BY id ASC
            $records->orderBy('mael_type_id', 'asc');

            // Paginate
            if ($request->get('page'))
                $records = $records->paginate(self::paginationRowCount);
            else
                $records = $records->get();
             //calc calories for   each meal
            foreach ($records as $record) {
                $used_calories = 0;
                $used_vitamin_protein = 0;
                $used_vitamin_iron = 0;
                $used_vitamin_a = 0;

                //calculates meal calories
                foreach ($record->meals as $meal) {
                    $used_calories += $meal->calories;
                    $used_vitamin_protein += $meal->vitamin_protein;
                    $used_vitamin_iron += $meal->vitamin_iron;
                    $used_vitamin_a += $meal->vitamin_a;
                }
                  // calories used
                $record->totals = [
                    "used_calories" => $used_calories,
                    "used_vitamin_protein" => $used_vitamin_protein,
                    "used_vitamin_iron" => $used_vitamin_iron,
                    "used_vitamin_a" => $used_vitamin_a,
                     // calculate remain
                    "remaining_calories" => $record->calories - $used_calories,
                    "remaining_vitamin_protein" => $record->vitamin_protein - $used_vitamin_protein,
                    "remaining_vitamin_iron" => $record->vitamin_iron - $used_vitamin_iron,
                    "remaining_vitamin_a" => $record->vitamin_a - $used_vitamin_a,
                ];
            }




            return $this->getResponse(self::multipleResultName, $records);
        }
        return $this->responseUnauthorized();
    }

 // calculate target & recalculate
    public function calculateTarget($userDetails, $calculateVitamins = true): JsonResponse
    {
        if ($userDetails) {

            // calculate user calories & vitamins
            $calories = Utils::getUserCalories($userDetails);
            $vitaminProtein = $calculateVitamins ? Utils::getUserVitaminProtein($userDetails) : $userDetails->vitamin_protein;
            $vitaminIron = $calculateVitamins ? Utils::getUserVitaminIron($userDetails) : $userDetails->vitamin_iron;
            $vitaminA = $calculateVitamins ? Utils::getUserVitaminA($userDetails) : $userDetails->vitamin_a;


            // Update user details
            UserDetails::where("user_id", $userDetails->user_id)->update([
                'calories' => $calories,
                'vitamin_protein' => $vitaminProtein,
                'vitamin_iron' => $vitaminIron,
                'vitamin_a' => $vitaminA,
            ]);

            // SELECT * FROM `male_types`
            $mealTypes = MealType::get();

            // Saves plan to user
            foreach ($mealTypes as $mealType) {
                // Check meal type to calculate calories & vitamins
                $planData = [
                    'user_id' => $userDetails->user_id,
                    'mael_type_id' => $mealType->id,
                    'calories' => $this->dividedCalories($mealType->id, $calories),
                    'vitamin_protein' => $this->dividedCalories($mealType->id, $vitaminProtein),
                    'vitamin_iron' => $this->dividedCalories($mealType->id, $vitaminIron),
                    'vitamin_a' => $this->dividedCalories($mealType->id, $vitaminA),
                ];

                // Get old plan data from user plans
                $userPlan = UserPlan::where("user_id", $userDetails->user_id)->where("mael_type_id", $mealType->id)->first();
                if ($userPlan != null) {
                    // Update plan
                    $userPlan->update($planData);
                } else {
                    // Create plan
                    UserPlan::create($planData);
                }
            }
            return $this->responseSuccessMessage("Saved successfully");
        }
        return $this->responseErrorCanNotSaveData();
    }
    //divided target calories into meals
    public function dividedCalories($mealTypeId, $calories)
    {
        switch ($mealTypeId) {
            case Utils::MEAL_TYPE_BREAKFAST:
                return $calories / 100 * 30; // Breakfast 20%

            case Utils::MEAL_TYPE_LUNCH:
                return $calories / 100 * 40; // Lunch 40%

            case Utils::MEAL_TYPE_DINNER:
                return $calories / 100 * 20; // Dinner 30%

            case Utils::MEAL_TYPE_SNACK:
            default:
                return $calories / 100 * 10; // Snack 10%
        }
    }
}
