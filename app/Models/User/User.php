<?php

namespace App\Models\User;

use App\Models\Base\BaseModel;
use App\Models\Plan\UserPlan;
use App\Utils\DBTables;

class User extends BaseModel
{

    /**
     * The table associated with the model.
     */
    protected $table = DBTables::USERS;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'fcm_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        
    ];


    public function details()
    {
        return $this->hasOne(UserDetails::class,"user_id");
    }

    public function plans()
    {
        return $this->hasMany(UserPlan::class,"user_id");
    }
}
