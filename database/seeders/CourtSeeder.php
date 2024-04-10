<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Court;

class CourtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Court::truncate();

        $courts = (array) [
            (object) ["name" => "Novak Djokovic", "status_id" => "5"],
            (object) ["name" => "Carlos Alcaraz", "status_id" => "5"],
            (object) ["name" => "Daniil Medvedev", "status_id" => "5"],
            (object) ["name" => "Jannik Sinner", "status_id" => "5"],
        ];

        foreach ($courts as $court) {
            $db_court = new Court;
            $db_court->name = $court->name;
            $db_court->status_id = $court->status_id;
            $db_court->save();
        }
    }
}
