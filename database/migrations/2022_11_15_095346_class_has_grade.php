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
        Schema::create('class_has_grade', function (Blueprint $table) {
            $table->integer('class_id')->unsigned();
            $table->integer('grade_id')->unsigned();
    
            $table->unique(['class_id', 'grade_id']);
            $table->foreign('class_id')->references('id')->on('class')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('grade_id')->references('id')->on('grade')
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
