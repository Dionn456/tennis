<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::truncate();

        $statuses = (array) [
            (object) ["code" => "open", "name" => "Open"],
            (object) ["code" => "invoiced", "name" => "Factuur verzonden"],
            (object) ["code" => "closed", "name" => "Gesloten"],
            (object) ["code" => "inactive", "name" => "Inactief"],
            (object) ["code" => "active", "name" => "Actief"],
        ];

        foreach ($statuses as $status) {
            $db_status = new Status;
            $db_status->code = $status->code;
            $db_status->name = $status->name;
            $db_status->save();
        }
    }
}
