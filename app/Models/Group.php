<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    protected $primaryKey = 'name';

    public $timestamps = false;
    public $keyType = 'string';

    public function users()
    {
        return $this->hasManyThrough(
            UserGroupDue::class,
            User::class,
            'id',
            'user_id',
            'name',
        );
    }
}
