<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['email' => 'romis.nesmelov@gmail.com', 'phone' => '+79262477725', 'password' => bcrypt('apg192'), 'active' => 1, 'is_admin' => 1],
            ['email' => 'lavkasyrkova@gmail.com', 'phone' => '+79855790411', 'password' => bcrypt('lavkasyrkova2019'), 'active' => 1, 'is_admin' => 1],
            ['email' => 'romis@nesmelov.com', 'phone' => '+79262477725', 'password' => bcrypt('apg192'), 'active' => 1, 'is_admin' => 0, 'office_id' => 3],
        ];

        foreach ($data as $user) {
            User::create($user);
        }
    }
}
