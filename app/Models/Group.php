<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    public $timestamps = false;

    protected $primaryKey = 'name';

    protected $fillable = [
        'name',
        'display_name',
        'prefix',
        'suffix',
        'color',
        'priority',
        'tab_list_order',
        'discord_role_id'
    ];

    public function users()
    {
        return $this->hasManyThrough(
            'App\Models\User',
            'App\Models\UserGroupDue',
            'user_id',
            'name',
            'group_name'
        );
    }
}
