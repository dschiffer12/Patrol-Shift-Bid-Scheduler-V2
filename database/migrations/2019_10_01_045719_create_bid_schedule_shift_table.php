<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBidScheduleShiftTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bid_schedule_shift', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('shift_id')->unsigned();
            $table->integer('bidding_schedule_id')->unsigned();
            $table->timestamps();

            $table->foreign('shift_id')->references('id')->on('shifts')->onCascade('delete');

            $table->foreign('bidding_schedule_id')->references('id')->on('bidding_schedules')->onCascade('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bid_schedule_shift');
    }
}
