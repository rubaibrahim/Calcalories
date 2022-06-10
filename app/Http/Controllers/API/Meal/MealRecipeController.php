<?php

namespace App\Http\Controllers\API\Meal;

use App\Http\Controllers\Base\ApiController;
use App\Models\Meal\MealRecipe;
use App\Utils\VitaminTypes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MealRecipeController extends ApiController
{
    const multipleResultName = "meal_recipes";

   //filter customized recipes,, getallmealsrecipes
    public function index(Request $request): JsonResponse
    {
        // SELECT * FROM `food_recipes`
        $records = MealRecipe::select("*")->with(["mealType"]);

        // Where
        $field = self::requestHas($request, 'meal_type_id');
        if ($field != null) {
            // where meal_type_id = $field
            $records->where('meal_type_id', "=", $field);
        }

        // $vitamins list of ids: [1=protein , 2=iron , 3=a]
        if ($vitamins = self::requestHas($request, 'vitamins')) {
            $vitamins = (array)$vitamins;
            foreach ($vitamins as $vitamin) {
                $vitamin = (object)$vitamin;
                if ($vitamin->id == VitaminTypes::PROTEIN) {
                    $records->whereBetween('vitamin_protein', [$vitamin->min, $vitamin->max]);
                } else if ($vitamin->id == VitaminTypes::IRON) {
                    $records->whereBetween('vitamin_iron', [$vitamin->min, $vitamin->max]);
                } else if ($vitamin->id == VitaminTypes::A) {
                    $records->whereBetween('vitamin_a', [$vitamin->min, $vitamin->max]);
                }
            }
        }

        if ($field = self::requestHas($request, 'search')) {
            // WHERE (name LIKE '%$field%' OR details LIKE '%$field%'  )
            $records->where(function ($query) use ($field) {
                $query->where('name', 'LIKE', "%$field%")
                    ->orWhere('details', 'LIKE', "%$field%");
            });
        }

        // Sort
        // ORDER BY id ASC
        $records->orderBy('id', 'asc');

        // Paginate
        if ($request->get('page'))
            $records = $records->paginate(self::paginationRowCount);
        else
            $records = $records->get();
    //return response recipes
        return $this->getResponse(self::multipleResultName, $records);
    }


    public function store(Request $request): JsonResponse
    {
        return $this->index($request);
    }
}
