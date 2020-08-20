<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGroupDue extends Model
{

    protected $table = 'users_groups_due';

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', 'group_name'
    ];

}
