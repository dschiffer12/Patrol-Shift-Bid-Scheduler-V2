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
            $table->integer('user_id')->unsigned();
            $table->integer('biddingschedule_id')->unsigned();
            $table->integer('bidding_spot');
            $table->boolean('waiting_to_bid');
            $table->boolean('bidding');
            $table->boolean('bid_submitted');
            $table->timestamp('start_time_bidding');
            $table->timestamp('end_time_bidding');
            $table->timestamps();
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
