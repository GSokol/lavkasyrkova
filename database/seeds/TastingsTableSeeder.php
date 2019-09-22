<?php

use Illuminate\Database\Seeder;
use App\Tasting;

class TastingsTableSeeder extends Seeder
{
    public function run()
    {
        for ($i=1;$i<=10;$i++) {
            Tasting::create([
                'name' => 'Самая крутая дегустация №'.$i,
                'time' => ($i == 1 ? (time()+(60*60*24*2)) : time() - (60*60*24*$i)) ,
                'active' => true,
                'office_id' => $i%2 ? 1 : 2
            ]);
        }
    }
}