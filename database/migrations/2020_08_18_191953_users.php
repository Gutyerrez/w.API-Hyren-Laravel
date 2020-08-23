<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Users extends Migration
{
    protected $table = 'users';

    public function up()
    {
        Schema::create($this->table, function(Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('name', 16)->unique();
            $table->bigInteger('discord_id')->nullable()->unique();
            $table->boolean('two_factor_authentication_enabled')->default(false);
            $table->string('two_factor_authentication_code', 8)->nullable()->unique();
            $table->string('twitter_access_token', 48)->nullable()->unique();
            $table->string('twitter_token_secret', 40)->nullable()->unique();
            $table->string('last_address');
            $table->integer('last_lobby_id')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
