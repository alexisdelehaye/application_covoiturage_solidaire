<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/*
 * Modifie la table 'users' :
 * - ajoute la colonne first_name:text
 * - ajoute la colonne last_name:text
 * - ajoute la colonne cars_id:text
 * - supprime la colonne name:text
 */

class ModifyUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
            $table->text('first_name')->nullable();
            $table->text('last_name')->nullable();
            $table->text('cars_id')->nullable();
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('cars_id');
            $table->text('name');
        });
    }
}
