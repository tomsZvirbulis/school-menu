<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recepie', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('prep_time');
            $table->float('cook_time');
            $table->integer('calories');
            $table->integer('servings');
            $table->unsignedBigInteger('ingredient_id')->nullable();
            $table->foreign('ingredient_id')->references('id')->on('ingredients');
            $table->unsignedBigInteger('caterer_id')->nullable();
            $table->foreign('caterer_id')->references('id')->on('caterer');
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
};
