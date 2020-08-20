<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $table = 'users';

    protected $primaryKey = 'id';

    public $keyType = 'string';

    protected $visible = [
        'name', 'groups'
    ];

    public function groups()
    {
        return $this->hasManyThrough(
            Group::class,
            UserGroupDue::class,
            'user_id',
            'name',
            'id',
            'group_name'
        );
    }

}
