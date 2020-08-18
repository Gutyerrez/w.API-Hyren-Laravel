<?php

use App\Extensions\Permission\Group;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Categories extends Migration
{
    protected $table = 'categories';

    public function up()
    {
        Schema::create($this->table, function(Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('slug');
            $table->string('restrict_read')->nullable();
            $table->string('restrict_write')->unsigned()->default(Group::DEFAULT()->key);
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
