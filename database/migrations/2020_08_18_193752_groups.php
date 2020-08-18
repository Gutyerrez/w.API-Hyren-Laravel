<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Groups extends Migration
{
    protected $table;

    public function up()
    {
        Schema::create($this->table, function(Blueprint $table) {
            $table->string('name')->primary();
            $table->string('display_name');
            $table->string('prefix');
            $table->string('suffix')->nullable();
            $table->string('color')->default('#AAAAAA');
            $table->integer('priority')->default(0);
            $table->integer('tab_list_order')->default(0);
            $table->bigInteger('discord_role_id')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
