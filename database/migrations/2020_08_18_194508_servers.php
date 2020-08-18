<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Servers extends Migration
{
    protected $table = 'servers';

    public function up()
    {
        Schema::create($this->table, function(Blueprint $table) {
            $table->string('name')->primary();
            $table->string('display_name');
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
