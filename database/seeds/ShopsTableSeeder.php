<?php

use Illuminate\Database\Seeder;
use App\Shop;

class ShopsTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['address' => 'м.Киевская,<br>Дорогомиловский рынок,<br>место: 201-202', 'latitude' => '55.742539', 'longitude' => '37.554286'],
            ['address' => 'м.Спортивная,<br>Усачёвский рынок,<br>ул.Усачёва, д.26', 'latitude' => '55.727374', 'longitude' => '37.567698'],
        ];
        
        foreach ($data as $item) {
            Shop::create($item);
        }
    }
}