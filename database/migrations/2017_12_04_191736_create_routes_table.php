<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->increments('id');
            $table->text('stops'); // arrêts effectués par le chauffeur, non null
            $table->boolean('type'); // type de trajet (récurrent / ponctuel)
            $table->text('days'); // départ ou non chaque jour de la semaine au format CSV tel que : 'mon=x,tue=x,wed=x,thu=x,fri=x,sat=x,sun=x' avec x = 0 ou 1 (0 pas de passage, 1 passage)


            // Heure de départ chaque jour de la semaine, NULL sinon
            $table->time('mon_hour')->nullable(true);
            $table->time('tue_hour')->nullable(true);
            $table->time('wed_hour')->nullable(true);
            $table->time('thu_hour')->nullable(true);
            $table->time('fri_hour')->nullable(true);
            $table->time('sat_hour')->nullable(true);
            $table->time('sun_hour')->nullable(true);

            $table->text('status'); // statut du trajet : planifié, en cours, terminé

            $table->timestamps(); // raccourci qui crée created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paths');
    }
}
