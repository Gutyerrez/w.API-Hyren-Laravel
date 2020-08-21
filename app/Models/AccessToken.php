<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{

    protected $table = 'access_tokens';

    protected $primaryKey = 'access_token';

    public $keyType = 'string';

    protected $fillable = [
        'token_type', 'access_token', 'due_at'
    ];

    protected $visible = [
        'token_type', 'access_token'
    ];

}
