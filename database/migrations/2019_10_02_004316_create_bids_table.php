<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('bidding_schedule_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('bid_shift_id')->unsigned();
            $table->integer('bid_early_shift_id')->unsigned();
            $table->timestamps();

            $table->foreign('bidding_schedule_id')->references('id')->on('bidding_schedules')->onCascade('delete');

            $table->foreign('user_id')->references('id')->on('users')->onCascade('delete');

            $table->foreign('bid_shift_id')->references('id')->on('bid_shifts')->onCascade('delete');

            $table->foreign('bid_early_shift_id')->references('id')->on('bid_early_shifts')->onCascade('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bids');
    }
}
