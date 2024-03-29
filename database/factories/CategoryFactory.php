<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Category::class, function (Faker $faker) {
    $name = $faker->name;
    return [
        'name' => $faker->name,
        'slug' => Str::slug($name),
    ];
});
