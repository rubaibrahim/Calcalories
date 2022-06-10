<?php

namespace App\Models\User;

use App\Models\Base\BaseModel;
use App\Utils\DBTables;

class UserNotification extends BaseModel
{

    /**
     * The table associated with the model.
     */
    protected $table = DBTables::USER_NOTIFICATIONS;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'type', // 1=notify, 2=action
        'title',
        'message',
        'ids', // [] : 1=protein , 2=iron , 3=a
        'is_read', // 1=Yes, 0=No
        "updated_at"
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'user_id',
    ];
}
