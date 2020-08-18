<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PunishCategories extends Migration
{
    protected $table = 'punish_categories';

    public function up()
    {
        Schema::create($this->table, function(Blueprint $table) {
            $table->string('name')->primary();
            $table->string('display_name');
            $table->text('description');
            $table->string('group_name');
            $table->json('durations')->default(json_encode([]));
            $table->boolean('enabled')->default(false);

            $table->foreign('group_name')->references('name')->on('groups')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
