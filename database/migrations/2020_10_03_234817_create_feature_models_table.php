<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeatureModelsTable extends Migration
{

    public function up()
    {
        Schema::create('feature_models', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('sub_title', 255);
            $table->string('description', 255);
            $table->string('external_url', 255);
            $table->string('image', 255);
        });
    }

    public function down()
    {
        Schema::dropIfExists('feature_models');
    }

}
