<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\Plan\UserPlanController;
use App\Http\Controllers\Base\ApiController;
use App\Models\Meal\MealType;
use App\Models\User\User;
use App\Models\User\UserDetails;
use App\Utils\Utils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiController
{
    const singleResultName = "user";
    const multipleResultName = "users";

    public function __construct()
    {
       $this->middleware('auth:sanctum');
    }

    public static function getUserData($user_id)
    {
        // select * from users where id = $user_id
        $record = User::with(["details", "plans.mealType"])->find($user_id);
        if ($record != null) {
            $record->details->age = Utils::getUserAge($record->details->date_of_birth);
        }
        return $record;
    }

    public function show(Request $request, $id): JsonResponse
    {
        if ($request->user() != null) {
                $user_id = $request->user()->id;
            $record = self::getUserData($user_id);
            if ($record != null) {
                $record->token = $request->bearerToken();
                return $this->getResponse(self::singleResultName, $record);
            }
            return $this->responseErrorThereIsNoData();
        }
        return $this->responseUnauthorized();
    }

    public function update(Request $request, $id): JsonResponse
    {
        // Check is user logged in
        if ($request->user()) {
            $user_id = $request->user()->id;

            $record = User::find($user_id);
            if ($record) {

                $validator = Validator::make($request->all(), [
                    'name' => ['required', 'string', 'min:3', 'max:20'],
                    'email' => ['required', 'email', 'max:50', 'unique:users,email,' . $user_id],
                    //'password' => ['sometimes', 'min:6', 'max:20'],
                ]);
                if ($validator->fails())
                    return $this->responseValidatorObject($validator->errors());

                if($request->get("password") != null && $request->get("password") != ""){
                       $validator = Validator::make($request->all(), [
                        'password' => ['sometimes', 'min:6', 'max:20'],
                    ]);
                    if ($validator->fails())
                        return $this->responseValidatorObject($validator->errors());

                }

                $data = [
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'fcm_token' => $request['fcm_token'],
                ];

                if (!empty($request->password))
                    $data['password'] = Hash::make($request['password']);

                // update user data
                $record->update($data);


                return $this->show($request, $user_id);
            }
            return $this->responseErrorCanNotSaveData();
        }
        return $this->responseUnauthorized();
    }

    public function updateDetails(Request $request): JsonResponse
    {
        // Check is user logged in
        if ($request->user()) {
            $user_id = $request->user()->id;

            $record = UserDetails::where("user_id", $user_id)->first();
            if ($record != null) {

                $validator = Validator::make($request->all(), [
                    'date_of_birth' => ['required'],
                    'gender' => ['required', 'string', 'max:1'],
                    'height' => ['required', 'numeric'],
                    'weight' => ['required', 'numeric'],

                ]);
                if ($validator->fails())
                    return $this->responseValidatorObject($validator->errors());

                $record->update([
                    'date_of_birth' => $request['date_of_birth'],
                    'gender' => $request['gender'],
                    'height' => $request['height'],
                    'weight' => $request['weight'],

                ]);

                // Update user plans
                (new UserPlanController())->calculateTarget($record, $request->get("update_vitamin") ?? true);

                return $this->show($request, $record->id);
            }
            return $this->responseErrorCanNotSaveData();
        }
        return $this->responseUnauthorized();
    }




}
