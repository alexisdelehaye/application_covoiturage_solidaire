<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemovePrefixedHoursFromRoutes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routes', function($table) {
            $table->dropColumn('mon_hour');
            $table->dropColumn('tue_hour');
            $table->dropColumn('wed_hour');
            $table->dropColumn('thu_hour');
            $table->dropColumn('fri_hour');
            $table->dropColumn('sat_hour');
            $table->dropColumn('sun_hour');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
