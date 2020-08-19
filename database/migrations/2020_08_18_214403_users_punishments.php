<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsersPunishments extends Migration
{
    protected $table = 'users_punishments';

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id', 36);
            $table->string('staffer_id', 36);
            $table->timestamp('start_time')->nullable();
            $table->enum('type', [
                'BAN',
                'TEMP_BAN',
                'MUTE'
            ]);
            $table->string('category');
            $table->bigInteger('durations');
            $table->string('custom_reason')->nullable();
            $table->string('proof')->nullable();
            $table->string('unban_staffer_id', 36)->nullable();
            $table->timestamp('unban_time')->nullable();
            $table->string('unban_reason')->nullable();
            $table->string('unban_category')->nullable();
            $table->boolean('hidden')->default(false);
            $table->boolean('perpetual')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->foreign('staffer_id')->references('id')->on('users')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->foreign('unban_staffer_id')->references('id')->on('users')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->foreign('category')->references('name')->on('punish_categories')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->foreign('unban_category')->references('name')->on('revoke_categories')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
