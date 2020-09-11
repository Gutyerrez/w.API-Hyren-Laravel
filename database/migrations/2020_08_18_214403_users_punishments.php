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
            $table->enum('punish_type', [
                'BAN',
                'TEMP_BAN',
                'MUTE',
                'DISCORD_MUTE'
            ]);
            $table->string('punish_category_name')->nullable();
            $table->bigInteger('duration');
            $table->string('custom_reason')->nullable();
            $table->string('proof')->nullable();
            $table->string('revoke_staffer_id', 36)->nullable();
            $table->timestamp('revoke_time')->nullable();
            $table->string('revoke_reason')->nullable();
            $table->string('revoke_category')->nullable();
            $table->boolean('hidden')->default(false);
            $table->boolean('perpetual')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->foreign('staffer_id')->references('id')->on('users')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->foreign('revoke_staffer_id')->references('id')->on('users')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->foreign('revoke_category_name')->references('name')->on('punish_categories')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->foreign('revoke_category_name')->references('name')->on('revoke_categories')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
