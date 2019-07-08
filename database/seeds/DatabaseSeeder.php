<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stops')->truncate();

        $path = '/Users/Vincent/Documents/Cours/UE33 - Projets/M3302 - PT/project/database/seeds/stops.csv';
        $file = fopen($path, 'r');

        while ( ($data = fgetcsv($file, 1000, ',')) !== false) {
            DB::table('stops')->insert([
                'name' => $data[0],
                'address' => $data[1],
                'zip' => $data[2],
                'town' => $data[3]
            ]);
        }

        fclose($file);
    }
}
