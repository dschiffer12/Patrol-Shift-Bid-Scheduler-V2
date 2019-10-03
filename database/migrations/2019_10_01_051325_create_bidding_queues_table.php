<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiddingQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bidding_queues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('bidding_schedule_id');
            $table->integer('bidding_spot');
            $table->boolean('waiting_to_bid');
            $table->boolean('bidding');
            $table->boolean('bid_submitted');
            $table->timestamp('start_time_bidding')->nullable();
            $table->timestamp('end_time_bidding')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->foreign('bidding_schedule_id')->references('id')->on('bidding_schedules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bidding_queues');
    }
}
