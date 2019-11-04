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
        Schema::dropIfExists('bids');

        Schema::create('bids', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('bidding_schedule_id');
            $table->unsignedBigInteger('shift_id');
            $table->unsignedTinyInteger('friday')->nullable();
            $table->unsignedTinyInteger('saturday')->nullable();
            $table->unsignedTinyInteger('sunday')->nullable();
            $table->unsignedTinyInteger('monday')->nullable();
            $table->unsignedTinyInteger('tuesday')->nullable();
            $table->unsignedTinyInteger('wednesday')->nullable();
            $table->unsignedTinyInteger('thursday')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('cascade');
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
        Schema::dropIfExists('bids');
    }
}
