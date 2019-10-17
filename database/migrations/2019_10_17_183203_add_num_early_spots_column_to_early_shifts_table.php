<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNumEarlySpotsColumnToEarlyShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('early_shifts', function (Blueprint $table) {
            $table->integer('num_early_spot');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('early_shifts', function (Blueprint $table) {
            $table->dropColumn('num_early_spot');
        });
    }
}
