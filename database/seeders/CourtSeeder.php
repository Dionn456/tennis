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
            (object) ["name" => "Novak Djokovic"],
            (object) ["name" => "Carlos Alcaraz"],
            (object) ["name" => "Daniil Medvedev"],
            (object) ["name" => "Jannik Sinner"],
        ];

        foreach ($courts as $court) {
            $db_court = new Court;
            $db_court->name = $court->name;
            $db_court->save();
        }
    }
}
