<?php

use App\Extensions\Permission\Group;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Threads extends Migration
{
    protected $table = 'threads';

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('forum_id');
            $table->string('user_id', 36);
            $table->string('title');
            $table->string('slug')->nullable();
            $table->boolean('promoted')->default(false);
            $table->boolean('sticky')->default(false);
            $table->boolean('closed')->default(false);
            $table->integer('views')->default(0);
            $table->integer('answers')->default(0);
            $table->timestamp('last_reply_at')->useCurrent();
            $table->string('restrict_read')->nullable();
            $table->string('restrict_write')->default(Group::DEFAULT()->key);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->foreign('forum_id')->references('id')->on('forums')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
