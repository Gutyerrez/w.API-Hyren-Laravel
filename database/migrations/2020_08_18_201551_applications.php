<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Extensions\Permission\Group;

class Applications extends Migration
{
    protected $table = 'applications';

    public function up()
    {
        Schema::create($this->table, function(Blueprint $table) {
            $table->string('name')->primary();
            $table->string('display_name');
            $table->text('description');
            $table->integer('slots')->default(10);
            $table->string('address');
            $table->integer('port');
            $table->enum('type', [
                'PROXY',
                'LOBBY',
                'BANNED',
                'SERVER_SPAWN',
                'SERVER_VIP',
                'SERVER_WORLD_NORTH',
                'SERVER_WORLD_WEST',
                'SERVER_WORLD_SOUTH',
                'SERVER_WORLD_EAST',
                'SERVER_END',
                'SERVER_MINE',
                'SERVER_ARENA',
                'SERVER_WAR',
                'SERVER_DUNGEON',
                'SERVER_TESTS',
                'SERVER_GENERIC'
            ]);
            $table->string('server_name');
            $table->string('restrict_join')->default(Group::MANAGER()->key);

            $table->foreign('server_name')->references('name')->on('servers')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
