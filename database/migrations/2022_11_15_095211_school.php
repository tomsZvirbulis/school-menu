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
        Schema::create('school', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('address_id');
            $table->foreign('address_id')->references('id')->on('address');
            $table->unsignedBigInteger('caterer');
            $table->foreign('caterer')->references('id')->on('caterer');
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
