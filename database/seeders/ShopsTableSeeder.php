<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shop;

class ShopsTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['address' => 'м.Киевская, Дорогомиловский рынок, место: 201-202. С 7.30 до 19.00', 'latitude' => '55.742539', 'longitude' => '37.554286'],
            ['address' => 'м.Спортивная, Усачёвский рынок, ул.Усачёва, д.26. С 9 до 22.30', 'latitude' => '55.727374', 'longitude' => '37.567698'],
        ];

        foreach ($data as $item) {
            Shop::create($item);
        }
    }
}
