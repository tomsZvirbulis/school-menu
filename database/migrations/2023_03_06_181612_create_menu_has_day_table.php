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
        Schema::create('menu_has_day', function (Blueprint $table) {
            $table->foreignId('menu')->constrained('menu');
            $table->foreignId('day')->constrained('day');
            $table->foreignId('recepie')->constrained('recepie');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_has_day');
    }
};
