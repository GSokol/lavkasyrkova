<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use App\Models\AddCategory;

class AddCategorySeeder extends Seeder
{
    public function run()
    {
        $additionalCategories = [
            [
                'name' => 'Сыры из козьего молока',
                'slug' => 'syry-iz-kozego-moloka',
                'image' => 'icon-goat.png',
            ],
            [
                'name' => 'Сыры из коровьего молока',
                'slug' => 'syry-iz-korovego-moloka',
                'image' => 'icon-cow.png',
            ],
            [
                'name' => 'Сыры из овечьего молока',
                'slug' => 'syry-iz-ovechego-moloka',
                'image' => 'icon-sheep.png',
            ],
        ];

        foreach ($additionalCategories as $category) {
            AddCategory::updateOrCreate(Arr::only($category, ['name']), $category)->save();
        }
    }
}
