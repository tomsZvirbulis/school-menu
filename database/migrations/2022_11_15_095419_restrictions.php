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
        Schema::create('restrictions', function (Blueprint $table) {
            $table->integer('class_id')->unsigned();
            $table->integer('ingredients_id')->unsigned();
    
            $table->unique(['class_id', 'ingredients_id']);
            $table->foreign('class_id')->references('id')->on('class')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('ingredients_id')->references('id')->on('ingredients')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('name');
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
