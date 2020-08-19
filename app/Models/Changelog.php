<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Changelog extends Model
{

    protected $table = 'changelogs';

    protected $fillable = [
        'title', 'changes'
    ];

    protected $visible = [
        'title', 'changes', 'created_at'
    ];

}
