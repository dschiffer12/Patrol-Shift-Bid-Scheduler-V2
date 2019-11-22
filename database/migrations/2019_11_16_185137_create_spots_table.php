<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shift_id');
            $table->integer('qty_available');
            $table->time('friday_s')->nullable();
            $table->time('friday_e')->nullable();
            $table->time('saturday_s')->nullable();
            $table->time('saturday_e')->nullable();
            $table->time('sunday_s')->nullable();
            $table->time('sunday_e')->nullable();
            $table->time('monday_s')->nullable();
            $table->time('monday_e')->nullable();
            $table->time('tuesday_s')->nullable();
            $table->time('tuesday_e')->nullable();
            $table->time('wednesday_s')->nullable();
            $table->time('wednesday_e')->nullable();
            $table->time('thursday_s')->nullable();
            $table->time('thursday_e')->nullable();
            $table->timestamps();

            $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spots');
    }
}
