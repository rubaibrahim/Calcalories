<?php

namespace App\Models\Meal;

use App\Models\Base\BaseModel;
use App\Utils\DBTables;


class MealType extends BaseModel
{
    /**
     * The table associated with the model.
     */
    protected $table = DBTables::MEAL_TYPES;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
    ];
}
