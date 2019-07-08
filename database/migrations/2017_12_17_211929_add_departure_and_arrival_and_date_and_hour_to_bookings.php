<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDepartureAndArrivalAndDateAndHourToBookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function($table) {
            $table->text('departure');
            $table->text('arrival');
            $table->date('date');
            $table->time('hour');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function($table) {
            $table->dropColumn('departure');
            $table->dropColumn('arrival');
            $table->dropColumn('date');
            $table->dropColumn('hour');
        });
    }
}
