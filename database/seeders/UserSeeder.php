<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $users = (array) [
            (object) ["name" => "Admin", "email" => "admin@gmail.com", "phone" => "06123456789", "password" => Hash::make('admin'), "role_id" => "1"],
            (object) ["name" => "Ewald", "email" => "ewald@gmail.com", "phone" => "06123456789", "password" => Hash::make('test'), "role_id" => "2"],
            (object) ["name" => "Sem", "email" => "sem@gmail.com", "phone" => "06123456789", "password" => Hash::make('test'), "role_id" => "2"],
            (object) ["name" => "Pim", "email" => "pim@gmail.com", "phone" => "06123456789", "password" => Hash::make('test'), "role_id" => "2"],
        ];

        foreach ($users as $user) {
            $db_user = new User;
            $db_user->name = $user->name;
            $db_user->email = $user->email;
            $db_user->phone = $user->phone;
            $db_user->password = $user->password;
            $db_user->role_id = $user->role_id;
            $db_user->save();
        }
    }
}
