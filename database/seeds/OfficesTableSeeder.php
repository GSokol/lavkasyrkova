<?php

use Illuminate\Database\Seeder;
use App\Office;

class OfficesTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['address' => '105005, г.Москва, ул.Бакунинская, 17/28, помещение XVII', 'latitude' => 55.774920, 'longitude' => 37.682462],
            ['address' => '109044, г.Москва, 3 Крутицкий переулок, дом 18, 2 этаж', 'latitude' => 55.731855, 'longitude' => 37.663943],
        ];
        
        foreach ($data as $item) {
            Office::create($item);
        }
    }
}