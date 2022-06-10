<?php

namespace App\Utils;

use Carbon\Carbon;

class Utils
{
    const Yes = 1;
    const No = '0';

    const Male = "M";
    const Female = "F";

    const SUPPORT = 1;
    const FEEDBACK = 2;

    const MEAL_TYPE_BREAKFAST = 1;
    const MEAL_TYPE_LUNCH = 2;
    const MEAL_TYPE_DINNER = 3;
    const MEAL_TYPE_SNACK = 4;

    public static function formatToNumber($data, $decimals = 2, $decimals_point = ".", $thousands_sep = ""): string
    {
        return number_format($data, $decimals, $decimals_point, $thousands_sep); // 123456.00
    }

    public static function getUserAge($birthDate): int
    {
        return Carbon::parse($birthDate)->age;
    }

    public static function getUserCalories($userDetails): int
    {
        $gender = $userDetails->gender;
        $height = $userDetails->height;
        $weight = $userDetails->weight;
        $age = Utils::getUserAge($userDetails->date_of_birth);

        if ($gender == Utils::Male) {
            return (13.75 * $weight) + (5 * $height) - (6.76 * $age) + 66;
        } else {
            return (9.56 * $weight) + (1.85 * $height) - (4.68 * $age) + 655;
        }
    }

    public static function getUserVitaminProtein($userDetails): int
    {
        $weight = $userDetails->weight;
        return 0.8 * $weight;
    }

    public static function getUserVitaminIron($userDetails): int
    {
        $gender = $userDetails->gender;
        $age = Utils::getUserAge($userDetails->date_of_birth);

        if ($age >= 18 && $age <= 50) {
            if ($gender == Utils::Male)
                return 8;
             else
                return 18;
        }
        return 0;
    }

    public static function getUserVitaminA($userDetails): int
    {
        $gender = $userDetails->gender;
        $age = Utils::getUserAge($userDetails->date_of_birth);

        if ($age >= 18 && $age <= 50) {
            if ($gender == Utils::Male)
                return 900;
             else
                return 700;
        }
        return 0;
    }
}
