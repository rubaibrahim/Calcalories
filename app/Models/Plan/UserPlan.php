<?php

namespace App\Models\Plan;

use App\Models\Base\BaseModel;
use App\Models\Meal\MealType;
use App\Models\User\User;
use App\Utils\DBTables;

class UserPlan extends BaseModel
{

    /**
     * The table associated with the model.
     */
    protected $table = DBTables::USER_PLANS;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'mael_type_id',
        'calories',
        'vitamin_protein',
        'vitamin_iron',
        'vitamin_a'
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'user_id',
        'mael_type_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,"user_id");
    }

    public function mealType()
    {
        return $this->belongsTo(MealType::class,"mael_type_id");
    }

    public function meals()
    {
        return $this->hasMany(UserPlanMeal::class,"user_plan_id");
    }
}
