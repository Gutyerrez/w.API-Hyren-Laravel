<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsersGroupsDue extends Migration
{
    protected $table = 'users_groups_due';

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id', 36);
            $table->string('group_name');
            $table->string('server_name');
            $table->timestamp('due_at');

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->foreign('group_name')->references('name')->on('groups')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->foreign('server_name')->references('name')->on('servers')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
