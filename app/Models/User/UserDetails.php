<?php

namespace App\Models\User;

use App\Models\Base\BaseModel;
use App\Utils\DBTables;

class UserDetails extends BaseModel
{

    /**
     * The table associated with the model.
     */
    protected $table = DBTables::USER_DETAILS;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'date_of_birth',
        'gender',
        'height',
        'weight',
        'calories',
        'vitamin_protein',
        'vitamin_iron',
        'vitamin_a',
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'id',
        'user_id',
    ];
}
