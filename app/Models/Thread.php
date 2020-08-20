<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{

    protected $table = 'threads';

    protected $fillable = [
        'title', 'forum_id', 'user_id'
    ];

}
