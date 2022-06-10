<?php


namespace App\Utils;


use App\Models\User\User;

class FCMUtils
{
    public static $appName = "CalCalories";

    public static function sendNotify($user_id, $data = [])
    {
        if ($user = User::find($user_id)) {
            // add to list
            $data['app'] = FCMUtils::$appName;

            // send notification
            return FCMUtils::sendFcmNotificationToken($user->fcm_token, $data);
        }
        return "Notification not send";
    }

    // Send FCM notification for users by token
    public static function sendFcmNotificationToken($fcm_token, $data): array
    {

        $url = 'https://fcm.googleapis.com/fcm/send';

        $headers = array(
            'Authorization: key=' . "AAAAEugV0ZU:APA91bFuM8J1We8VbuHyk2lssb_JFxHRTE34IVbWbnqT9vfH1CNkWJKBSK-tFnY6tG2O4dBQy2PTF0Cau5oNrf32EDv5xeE2efOmm3Utd4EcWjiDoccWLiFNKXMrSSm-2HYF35xgQNvQ",
            'Content-Type: application/json'
        );

        $fields = array(
            'to' => $fcm_token,
            'data' => $data,
            "android" => [
                "priority" => "high"
            ],
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);


        $resultData['request'] = $fields;
        $resultData['result'] = $result;
        if ($result === FALSE) {
            $resultData['error'] = curl_error($ch);
        }
        return $resultData;
    }

}
