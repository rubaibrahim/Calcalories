<?php

namespace App\Http\Controllers\API\Plan;

use App\Http\Controllers\API\User\UserNotificationController;
use App\Http\Controllers\Base\ApiController;
use App\Models\Plan\UserPlanMeal;
use App\Models\User\UserDetails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserPlanMealController extends ApiController
{
    const singleResultName = "user_plan_meal";
    const multipleResultName = "user_plan_meals";

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function store(Request $request): JsonResponse
    {
        if ($request->user()) {
            $validator = Validator::make($request->all(), [
                'user_plan_id' => ['required', 'numeric'],
                'name' => ['required', 'string', 'max:255'],
                'calories' => ['required', 'numeric'],
                'vitamin_protein' => ['required', 'numeric'],
                'vitamin_iron' => ['required', 'numeric'],
                'vitamin_a' => ['required', 'numeric'],
            ]);
            if ($validator->fails() == true)
                return $this->responseValidatorObject($validator->errors());




            $record = UserPlanMeal::create([
                'user_plan_id' => $request['user_plan_id'],
                'name' => $request['name'],
                'calories' => $request['calories'],
                'vitamin_protein' => $request['vitamin_protein'],
                'vitamin_iron' => $request['vitamin_iron'],
                'vitamin_a' => $request['vitamin_a'],
                'updated_at' => $request['updated_at'] ?? date('Y-m-d H:i:s'),
            ]);


            // Check user totals
            $record->details = (new UserNotificationController())->calculateTotals($request->user()->id,$record->updated_at);


            return $this->postResponse(self::singleResultName, $record);
        }
        return $this->responseUnauthorized();
    }
       // deleted from diary page
    public function destroy(Request $request, $id): JsonResponse
    {
        if ($request->user()) {
            $record = UserPlanMeal::find($id);
            return self::deleteResponse($record);
        }
        return $this->responseUnauthorized();
    }
}
