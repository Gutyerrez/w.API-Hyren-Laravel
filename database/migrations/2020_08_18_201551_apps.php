<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Extensions\Permission\Group;

class Apps extends Migration
{
    protected $table = 'apps';

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
                'SERVER_SPAWN',
                'SERVER_VIP',
                'SERVER_WORLD_SPAWN',
                'SERVER_WORLD_NORTH',
                'SERVER_WORLD_WEST',
                'SERVER_WORLD_SOUTH',
                'SERVER_WORLD_EAST'
            ]);
            $table->string('server');
            $table->string('restrict_join')->default(Group::MANAGER()->key);

            $table->foreign('server')->references('name')->on('servers')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
