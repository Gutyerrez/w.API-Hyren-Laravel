<?php

use App\Extensions\Permission\Group;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Forums extends Migration
{
    protected $table = 'forums';

    public function up()
    {
        Schema::create($this->table, function(Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->integer('parent_id')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('slug')->nullable();
            $table->integer('template_thread_id');
            $table->string('restrict_read')->nullable();
            $table->string('restrict_write')->default(Group::DEFAULT()->key);
            $table->string('threads_restrict_read')->nullable();
            $table->string('threads_restrict_write')->defaultTo(Group::DEFAULT()->key);
            $table->string('threads_restrict_move')->defaultTo(Group::MANAGER()->key);
            $table->string('threads_restrict_close')->defaultTo(Group::MANAGER()->key);
            $table->integer('threads_fallback_forum_id')->nullable();

            $table->foreign('category_id')->references('id')->on('categories')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->foreign('parent_id')->references('id')->on($this->table)
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
