<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['email' => 'romis.nesmelov@gmail.com', 'phone' => '+79262477725', 'password' => bcrypt('apg192'), 'active' => 1, 'is_admin' => 1],
            ['email' => 'romis@nesmelov.com', 'phone' => '+79262477725', 'password' => bcrypt('apg192'), 'active' => 1, 'is_admin' => 0, 'office_id' => 1],
        ];

        foreach ($data as $user) {
            User::create($user);
        }
    }
}