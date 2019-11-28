<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBiddingQueueIdToBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bids', function (Blueprint $table) {
            $table->unsignedBigInteger('bidding_queue_id')->nullable();

            $table->foreign('bidding_queue_id')->references('id')->on('bidding_queues')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bids', function (Blueprint $table) {
            $table->dropForeign(['bidding_queue_id']);
            $table->dropColumn(['bidding_queue_id']);
        });
    }
}
