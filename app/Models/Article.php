<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $fillable = [
        'thread_id', 'post_id'
    ];

    function post()
    {
        return $this->hasOne(
            Post::class,
            'id',
            'post_id'
        );
    }

    function thread()
    {
        return $this->hasOne(
            Thread::class,
            'id',
            'thread_id'
        );
    }

}
