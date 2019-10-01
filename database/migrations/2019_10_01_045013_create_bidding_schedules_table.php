<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiddingSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bidding_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('start_day');
            $table->date('end_day');
            $table->string('name');
            $table->integer('response_time');
            $table->boolean('save_as_template');
            $table->boolean('currently_active');
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
        Schema::dropIfExists('bidding_schedules');
    }
}
