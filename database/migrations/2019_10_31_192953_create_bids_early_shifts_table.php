<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBidsEarlyShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('bid_early_shifts');

        Schema::create('bid_early_shifts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bid_id');
            $table->unsignedTinyInteger('friday')->nullable();
            $table->unsignedTinyInteger('saturday')->nullable();
            $table->unsignedTinyInteger('sunday')->nullable();
            $table->unsignedTinyInteger('monday')->nullable();
            $table->unsignedTinyInteger('tuesday')->nullable();
            $table->unsignedTinyInteger('wednesday')->nullable();
            $table->unsignedTinyInteger('thursday')->nullable();
            $table->timestamps();

            $table->foreign('bid_id')->references('id')->on('bids')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bid_early_shifts');
    }
}
