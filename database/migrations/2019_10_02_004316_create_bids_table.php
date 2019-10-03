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
            $table->unsignedBigInteger('bidding_schedule_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('bid_shift_id');
            $table->unsignedBigInteger('bid_early_shift_id');
            $table->timestamps();

            $table->foreign('bidding_schedule_id')->references('id')->on('bidding_schedules')->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->foreign('bid_shift_id')->references('id')->on('bid_shifts')->onDelete('cascade');

            $table->foreign('bid_early_shift_id')->references('id')->on('bid_early_shifts')->onDelete('cascade');
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
