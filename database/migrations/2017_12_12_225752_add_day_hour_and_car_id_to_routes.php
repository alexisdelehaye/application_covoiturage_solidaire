<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDayHourAndCarIdToRoutes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routes', function($table) {
            $table->time('day_hour')->nullable();
            $table->integer('car_id')->nullable();
            $table->foreign('car_id')->references('id')->on('cars')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('routes', function($table) {
            $table->dropColumn('day_hour');
            $table->dropColumn('car_id');
        });
    }
}
