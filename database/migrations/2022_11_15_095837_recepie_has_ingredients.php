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
        Schema::create('recepie_has_ingredients', function (Blueprint $table) {
            $table->integer('recepie_id')->unsigned();
            $table->integer('ingredients_id')->unsigned();
    
            $table->unique(['recepie_id', 'ingredients_id']);
            $table->foreign('recepie_id')->references('id')->on('recepie')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('ingredients_id')->references('id')->on('ingredients')
                ->onDelete('cascade')->onUpdate('cascade');
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
