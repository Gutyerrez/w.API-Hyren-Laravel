<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AccessTokens extends Migration
{
    protected $table = 'access_tokens';

    public function up()
    {
        Schema::create($this->table, function(Blueprint $table) {
            $table->string('token_type');
            $table->string('access_token')->primary();
            $table->timestamp('due_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
