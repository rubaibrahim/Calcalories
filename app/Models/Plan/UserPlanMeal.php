<?php

namespace App\Models\Plan;

use App\Models\Base\BaseModel;
use App\Utils\DBTables;

class UserPlanMeal extends BaseModel
{
    /**
     * The table associated with the model.
     */
    protected $table = DBTables::USER_PLAN_MEALS;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_plan_id',
        'name',
        'calories',
        'vitamin_protein',
        'vitamin_iron',
        'vitamin_a',
        'updated_at',
    ];

    public function userPlan()
    {
        return $this->belongsTo(UserPlan::class, "user_plan_id");
    }
}
