<?php

namespace App\Http\Controllers\API\Meal;

use App\Http\Controllers\Base\ApiController;
use App\Models\Meal\MealType;
use App\Utils\FileUtil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MealTypeController extends ApiController
{
    const multipleResultName = "male_types";


    public function index(Request $request): JsonResponse
    {
        // SELECT * FROM `male_types`
        $records = MealType::select("*");

        // Where
        if ($field = self::requestHas($request, 'search')) {
            // WHERE neme LIKE '%$field%'
            $records->where(function ($query) use ($field) {
                $query->where('name', 'LIKE', "%$field%");
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

        return $this->getResponse(self::multipleResultName, $records);
    }


    //return url of photo
    public function store(Request $request): JsonResponse
    {
        $imgUrl = (new FileUtil)->save($request, 'image', "meals/images", "img_");


        if ($imgUrl) {
            return $this->postResponse("data", [
                "img_url" => $imgUrl,
                "google_url" => "https://images.google.com/searchbyimage?image_url=$imgUrl",
            ]);
        } else
            return $this->responseErrorThereIsNoData();
    }
}
