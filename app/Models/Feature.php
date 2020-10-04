<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{

    protected $fillable = [
        'title', 'sub_title', 'description', 'external_url', 'image'
    ];

}
