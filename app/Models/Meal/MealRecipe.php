<?php

namespace App\Models\Meal;

use App\Models\Base\BaseModel;
use App\Utils\DBTables;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MealRecipe extends BaseModel
{
    /**
     * The table associated with the model.
     */
    protected $table = DBTables::MEAL_RECIPES;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'meal_type_id',
        'name',
        'details',
        'calories',
        'vitamin_protein',
        'vitamin_iron',
        'vitamin_a',
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'meal_type_id',
    ];

    public function mealType()
    {
        return $this->belongsTo(MealType::class,"meal_type_id");
    }
}
