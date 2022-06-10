<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Base\ApiController;
use App\Models\Plan\UserPlanMeal;
use App\Models\User\UserDetails;
use App\Models\User\UserNotification;
use App\Utils\FCMUtils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserNotificationController extends ApiController
{
    const singleResultName = "user_notification";
    const multipleResultName = "user_notifications";

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request): JsonResponse
    {
        // Check is user logged in
        if ($request->user()) {
            $user_id = $request->user()->id;

            // SELECT * FROM `user_plans`
            $records = UserNotification::select("*")
                //->where("is_read", "=", 0)
                ->where("user_id", "=", $user_id);

            if ($field = self::requestHas($request, 'updated_at')) {
                // where DATE(updated_at) = $field
                $records->whereDate('updated_at', $field);
            }

            // Where
            if (($field = self::requestHas($request, 'type')) != null) {
                // where type = $field
                $records->where('type', "=", $field);
            }

            // Sort
            // ORDER BY id ASC
            $records->orderBy('id', 'desc');

            // Paginate
            if ($request->get('page'))
                $records = $records->paginate(self::paginationRowCount);
            else
                $records = $records->get();

            return $this->getResponse(self::multipleResultName, $records);
        }
        return $this->responseUnauthorized();
    }

    public function update(Request $request, $id): JsonResponse
    {
        // Check is user logged in
        if ($request->user()) {
            $user_id = $request->user()->id;

            $record = UserNotification::where("user_id", $user_id)->find($id);
            if ($record) {
                $record->update([
                    "is_read" => 1
                ]);
                return $this->responseSuccessMessage();
            }
            return $this->responseErrorCanNotSaveData();
        }
        return $this->responseUnauthorized();
    }




    public function calculateTotals($userId,$updated_at)
    {

        $userDetails = UserDetails::where("user_id", $userId)->first();
        if ($userDetails) {


            $totals = UserPlanMeal::leftjoin("user_plans", "user_plans.id", "=", "user_plan_meals.user_plan_id")
                ->select(
                    DB::raw("IFNULL(SUM(user_plan_meals.calories),0) as calories"),
                    DB::raw("IFNULL(SUM(user_plan_meals.vitamin_protein),0) as vitamin_protein"),
                    DB::raw("IFNULL(SUM(user_plan_meals.vitamin_iron),0) as vitamin_iron"),
                    DB::raw("IFNULL(SUM(user_plan_meals.vitamin_a),0) as vitamin_a")
                )
                ->where("user_plans.user_id", $userId)
                ->whereDate('user_plan_meals.updated_at', $updated_at)
                ->first();

            $userDetails->totals = $totals;
            if ($totals) {

                if ($totals->calories >= $userDetails->calories) {
                    $userDetails->caloriesNotify = $this->addNotification($userId, 1, "Warning!",
                        "You've reached your calories for the day", [],$updated_at);
                } else {
                    //$hour = date('H');
                    //if($hour > 0) {
                        $message = "Your previous meal did not contain enough amounts of vitamin ";

                        $ids = [];
                        if ($userDetails->vitamin_protein > $totals->vitamin_protein) {
                            $ids[] = 1; // vitamin_protein required
                            $message .= " protein";
                        }
                        if ($userDetails->vitamin_iron > $totals->vitamin_iron) {
                            $ids[] = 2; // vitamin_iron required
                            if (count($ids) == 2)
                                $message .= " and";
                            $message .= " iron";
                        }
                        if ($userDetails->vitamin_a > $totals->vitamin_a) {
                            $ids[] = 3;     // vitamin_a required
                            if (count($ids) >= 2)
                                $message .= " and vitamin";
                            $message .= " A";
                        }

                        if (count($ids) > 0) {
                            $message .= "\nBrowse this menu you may like at your next meal.";
                            $userDetails->vitaminsNotify = $this->addNotification($userId, 2, "Suggestion!",
                                $message, $ids,$updated_at);
                        }
                   // }
                }
            }
        }
        return $userDetails;
    }

    private function addNotification($userId, $type, $title, $message, $ids = [],$updated_at = null)
    {
        UserNotification::create([
            'user_id' => $userId,
            'type' => $type, // 1=notify, 2=action
            'title' => $title,
            'message' => $message,
            'ids' => json_encode($ids), // [] : 1=protein , 2=iron , 3=a
            'is_read' => 0, // 1=Yes, 0=No
            "updated_at" => $updated_at ?? date("Y-m-d H:i:s")
        ]);

        return FCMUtils::sendNotify($userId, [
            "type" => "support",
            "message_type" => $type,
            "title" => $title,
            "message" => $message,
        ]);
    }

}
